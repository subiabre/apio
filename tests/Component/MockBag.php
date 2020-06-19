<?php

namespace Apio\Tests\Component;

use Apio\Component\Bag;

class MockBag extends Bag
{
    public $bag;

    public function __construct()
    {
        $this->bag = new Bag;
    }
}
