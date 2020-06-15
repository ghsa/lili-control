<?php


namespace LiliControl\tests\Unit;


use LiliControl\tests\TestCase;
use LiliControl\tests\User;

class PageTraitTest extends TestCase
{

    /** @test */
    public function return_get_page_title()
    {
        $user = new User();
        $this->assertEquals("User", $user->getPageTitle());
    }

    /** @test */
    public function return_get_base_name()
    {
        $user = new User();
        $this->assertEquals("user", $user->getBaseName());
    }

    /** @test */
    public function return_get_base_route_name()
    {
        $user = new User();
        $this->assertEquals("dashboard.user", $user->getBaseRouteName());
    }

}
