<?php declare(strict_types=1);

namespace Apio\Tests\Storage;

use Apio\Storage\Bag;

class BagMock extends Bag
{
    public $bag;

    public $prop1 = 0;

    public $prop2 = '';

    public function __construct()
    {
        $this->bag = new Bag;
    }
}
