<?php declare(strict_types=1);

namespace Apio\Tests\Storage;

use Apio\Storage\Bag;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class BagTest extends TestCase
{
    public function testStoresAnyValue()
    {
        $bag = new Bag;

        $bag->string = 'string';
        $bag->array = ['one', 'two'];
        $bag->object = new Bag;
        $bag->fn = fn() => true;

        $this->assertIsArray($bag->array);
        $this->assertSame('string', $bag->string);
        $this->assertSame(2, \count($bag->array));
        $this->assertInstanceOf(Bag::class, $bag->object);
        $this->assertIsCallable($bag->fn);
        $this->assertTrue($bag->fn());
    }

    public function testReturnsNullOnNonExistingKeys()
    {
        $bag = new Bag;

        $this->assertNull($bag->iDontExist);
        $this->assertNull($bag->iDontExist());
    }

    public function testBagChild()
    {
        $bag = new BagMock;

        $this->assertInstanceOf(Bag::class, $bag->bag);
    }

    public function testFromObjectSerialization()
    {
        $bag = new Bag;
        $bagMock = new BagMock;

        $bag->fromObject($bagMock);

        $this->assertNotNull($bag->prop1);
        $this->assertIsInt($bag->prop1);
        $this->assertNotNull($bag->prop2);
        $this->assertIsString($bag->prop2);
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
