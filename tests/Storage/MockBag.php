<?php

namespace Apio\Tests\Storage;

use Apio\Storage\Bag;

class MockBag extends Bag
{
    public $bag;

    public function __construct()
    {
        $this->bag = new Bag;
    }
}
