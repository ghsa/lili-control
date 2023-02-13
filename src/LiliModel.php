<?php

namespace LiliControl;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use LiliControl\Traits\PageTrait;

class LiliModel extends Model
{

    use PageTrait;

    /**
     * Return a list of properties for images of the model
     * the image field name should be the key of array
     *
     * [
     *  'image' => ['width' => 100, 'height' => 100, 'quality' => 70]
     * ]
     *
     * @return array
     */
    public function getImageProperties(): array
    {
        return [];
    }

    public function getFilePath($attribute, $disk = 's3'): string
    {
        if (empty($this->$attribute)) {
            return '';
        }
        return Storage::disk($disk)->url($this->$attribute);
    }

    /**
     * Return an array of rules to validate fields if Laravel Request
     */
    public function getValidationFields(): array
    {
        return [];
    }

    public function getFillableFields(): array
    {
        return $this->fillable;
    }

    /**
     * Apply a query builder instructions on filters
     */
    public function applyQueryBuilder(Builder $builder): Builder
    {
        return $builder;
    }


    /**
     * Fields to be returned in CSV export
     */
    public function selectCSVFields(): array
    {
        return [];
    }

    /**
     * Fields to be parsed in return of CSV
     *
     * Example:
     *  return [
     * 'status' => function ($status) {
     * return $status == 1 ? 'Active' : 'Inactive';
     * },
     * ];
     */
    public function selectCSVComputedFields(): array
    {
        return [
            'status' => function ($field) {
                return self::getStatusList()[$field];
            },
        ];
    }
}
