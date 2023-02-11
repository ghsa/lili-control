<?php


namespace LiliControl\tests;


use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable;
use LiliControl\LiliModel;

class User extends LiliModel implements Authenticatable, Authorizable
{
    use \Illuminate\Auth\Authenticatable, \Illuminate\Foundation\Auth\Access\Authorizable;

    protected $fillable = [
        'name',
        'email',
        'image'
    ];

    public function getValidationFields(): array
    {
        return [
            'name' => 'required',
        ];
    }
}
