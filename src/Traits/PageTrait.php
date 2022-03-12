<?php

namespace LiliControl\Traits;

trait PageTrait
{
    public $baseRoute = 'dashboard.';

    public function getPageTitle()
    {
        $title = ucfirst(class_basename($this));
        $title = implode(" ", preg_split('/(?=[A-Z])/', $title));
        return trim($title);
    }

    public function getBaseName()
    {
        return lcfirst(class_basename($this));
    }

    public function getBaseRouteName()
    {
        return $this->baseRoute . $this->getBaseName();
    }
}
