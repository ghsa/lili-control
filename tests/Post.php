<?php

namespace LiliControl\tests;

use Illuminate\Database\Eloquent\Builder;
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

    public function getValidationFields(): array
    {
        return [
            'user_id' => 'required',
            'title' => 'required',
        ];
    }

    public function applyQueryBuilder(Builder $builder): Builder
    {
       $builder->join('users', 'users.id', '=', 'posts.user_id');
       return $builder;
    }
}
