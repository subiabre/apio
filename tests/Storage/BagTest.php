<?php

namespace Apio\Tests\Storage;

use Apio\Storage\Bag;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;

class BagTest extends TestCase
{
    public function testStoresAnyValue()
    {
        $bag = new Bag;

        $bag->string = 'string';
        $bag->array = ['one', 'two'];
        $bag->object = new Bag;

        $this->assertIsArray($bag->array);
        $this->assertSame('string', $bag->string);
        $this->assertSame(2, \count($bag->array));
        $this->assertInstanceOf(Bag::class, $bag->object);
    }

    public function testBagChild()
    {
        $bag = new BagMock;

        $this->assertInstanceOf(Bag::class, $bag->bag);
    }

    public function testArraySerialization()
    {
        $bag = new Bag;

        $bag->name = 'John';
        $bag->age = '33';
        $bag->ignore = 'Ignore this';

        $expected = ['name' => 'John', 'age' => '33'];

        $this->assertSame($expected, $bag->toArray(['ignore']));
        $this->assertIsString($bag->ignore);
    }
}
