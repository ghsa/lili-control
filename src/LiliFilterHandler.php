<?php

namespace LiliControl;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

/**
 * Filter Handler class apply filters on a query based on
 * filters fields on request.
 * The input should follow this pattern: filters[columnName.operator]"
 *
 * Example of a search for equal values:
 * <input name="filters[age.=]" />
 * Example of a like search by name:
 * <input name="filters[name.like]" />
 *
 */

class LiliFilterHandler
{
    private $model;

    public function __construct(Model $model, $autoStart = true)
    {
        $this->model = $model;
        if ($autoStart)
            $this->setFiltersFromRequest();
    }

    public function addFilter($field, $operator, $value)
    {
        $dataFilter = $this->getFilters();
        $dataFilter[] = [
            'field' => $field,
            'operator' => $operator,
            'value' => $value
        ];
        Session::put($this->getFilterName(), $dataFilter);
    }

    /**
     * Use to catch filters
     */
    public function setFiltersFromRequest()
    {
        $this->resetRequestFilters();

        if (empty(request()->filters)) {
            return null;
        }

        foreach (request()->filters as $key => $value) {
            list($field, $operator) = $this->getFieldOperator($key);
            $this->addFilter($field, $operator, $value);
        }
    }

    private function getFieldOperator($key)
    {
        preg_match("/(.*)(\..*)$/", $key, $matches);
        return [$matches[1], str_replace(".", "", $matches[2])];
    }

    public function resetRequestFilters()
    {
        if (request()->isMethod('post') || (request()->isMethod('get') && empty(request()->page))) {
            $this->clearFilters();
        }
    }

    /**
     * Clean filters only if there is no pagination request
     * or change order request
     */
    public function clearFilters()
    {
        if (
            !empty(request()->page)
            || !empty(request()->order)
            || (!empty(request()->keep_filters) && request()->keep_filters = 1)
        )
            return;
        Session::remove($this->getFilterName());
    }

    public function getFilters()
    {
        return Session::get($this->getFilterName());
    }

    public function getValue($name)
    {
        list($field, $operator) = $this->getFieldOperator($name);
        $filters = $this->getFilters();

        if (empty($filters)) {
            return null;
        }

        $result = null;
        foreach ($filters as $filter) {
            if ($filter['field'] == $field && $filter['operator'] == $operator) {
                return $filter['value'];
            }
        }
        return null;
    }

    private function getFilterName()
    {
        return 'filters.' . str_replace("/", ".", get_class($this->model));
    }

    /**
     * Use to apply filters
     */
    public function applyFilters(Builder $query, $prefix = null)
    {
        $filters = $this->getFilters();

        if (empty($filters)) {
            return $query;
        }

        $prefix = !empty($prefix) ? $prefix . "." : null;

        foreach ($filters as $filter) {
            if ($filter['value'] == null)
                continue;
            $filter['value'] = $filter['operator'] == 'like' ? '%' . $filter['value'] . '%' : $filter['value'];
            $query->where($prefix . $filter['field'], $filter['operator'], $filter['value']);
        }
        return $query;
    }
}
