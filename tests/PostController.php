<?php

namespace LiliControl\tests;

use LiliControl\LiliController;

class PostController extends LiliController
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }
}
