<?php


namespace LiliControl;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class LiliOrderFilterHandler
{
    private $model;

    const ORDER_SESSION_NAME = 'lili-order';
    const DIRECTION_SESSION_NAME = 'lili-direction';

    public function __construct(Model $model)
    {
        $this->model = $model;
        $this->setOrderFromRequest();
    }

    public function setOrderFromRequest()
    {
        if (empty(request()->order)) {
            $this->removeOrderIfBlankRequest();
            return ;
        }
        $direction = 'desc';
        if(empty($this->getOrderValue()) || $this->getOrderDirection() == 'desc') {
           $direction = 'asc';
        }
        $this->setOrder(request()->order, $direction);
    }

    /**
     * Remover order only if there is no pagination request or
     * filter request
     */
    private function removeOrderIfBlankRequest()
    {
        $filterHandler = new LiliFilterHandler($this->model, false);
        if(empty(request()->page) && $filterHandler->getFilters() == null) {
            $this->clearOrder();
        }
    }

    public function setOrder($value, $direction = 'asc') {
        Session::put(self::ORDER_SESSION_NAME, $value);
        Session::put(self::DIRECTION_SESSION_NAME, $direction);
    }

    public function clearOrder()
    {
        Session::remove(self::ORDER_SESSION_NAME);
        Session::remove(self::DIRECTION_SESSION_NAME);
    }

    public function getOrderValue()
    {
        return Session::get(self::ORDER_SESSION_NAME);
    }

    public function getOrderDirection()
    {
        return Session::get(self::DIRECTION_SESSION_NAME);
    }

    /**
     * Apply order parameters in query builder
     *
     * @param Builder $builder
     * @return Builder
     */
    public function applyOrder(Builder $builder)
    {
        if(empty($this->getOrderValue())) {
            return $builder;
        }
        $builder->orderBy($this->getOrderValue(), $this->getOrderDirection());
        return $builder;
    }
}
