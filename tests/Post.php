<?php

namespace LiliControl\tests;

use LiliControl\LiliModel;

class Post extends LiliModel
{

    protected $fillable = [
       'user_id',
        'title'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getValidationFields()
    {
        return [
            'user_id' => 'required',
            'title' => 'required',
        ];
    }

    public function applyQueryBuilder($builder)
    {
       $builder->join('users', 'users.id', '=', 'posts.user_id');
       return $builder;
    }
}
