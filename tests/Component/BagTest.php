<?php

namespace Apio\Tests\Component;

use Apio\Component\Bag;
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
        $bag = new MockBag;

        $this->assertInstanceOf(Bag::class, $bag->bag);
    }

    public function testDefaultBagSerializer()
    {
        $bag = new Bag;

        $this->assertObjectHasAttribute('serializer', $bag);
        $this->assertInstanceOf(Serializer::class ,$bag->serializer);
    }

    public function testSerialization()
    {
        $bag = new Bag;

        $bag->name = 'John';
        $bag->age = '33';
        $bag->ignore = 'Ignore this';

        $expectedJson = \json_encode(['name' => 'John', 'age' => '33']);
        $actualJson = $bag->jsonSerialize(['ignore']);

        $this->assertJsonStringEqualsJsonString($expectedJson, $actualJson);
    }
}
