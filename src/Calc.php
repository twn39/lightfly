<?php
declare(strict_types=1);

namespace App;

class Calc
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function add()
    {
        return $this->container['config'];
    }
}
