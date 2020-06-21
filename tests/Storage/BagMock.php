<?php

namespace Apio\Tests\Storage;

use Apio\Storage\Bag;

class BagMock extends Bag
{
    public $bag;

    public function __construct()
    {
        $this->bag = new Bag;
    }
}
