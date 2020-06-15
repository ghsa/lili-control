<?php

namespace LiliControl\tests;

use LiliControl\LiliController;

class UserController extends LiliController
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
