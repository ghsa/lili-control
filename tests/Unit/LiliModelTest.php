<?php


namespace LiliControl\tests\Unit;


use LiliControl\tests\TestCase;
use LiliControl\tests\User;

class LiliModelTest extends TestCase
{

    /** @test */
    public function return_get_validation_fields()
    {
        $user = new User();
        $this->assertContains("name", $user->getFillableFields());
        $this->assertContains("email", $user->getFillableFields());
        $this->assertContains("image", $user->getFillableFields());
    }

}
