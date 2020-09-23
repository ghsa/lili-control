<?php

namespace LiliControl;

use Illuminate\Database\Eloquent\Model;
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
    public function getImageProperties()
    {
        return [];
    }

    public function getFilePath($attribute, $disk = 'public')
    {
        return Storage::disk($disk)->url($this->$attribute);
    }

    /**
     * Return an array of rules to validate fields if Laravel Request
     */
    public function getValidationFields()
    {
        return [];
    }

    public function getFillableFields()
    {
        return $this->fillable;
    }

    /**
     * Apply a query builder instructions on filters
     */
    public function applyQueryBuilder($builder)
    {
        return $builder;
    }
}
