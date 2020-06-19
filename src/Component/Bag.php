<?php

namespace Apio\Component;

use JsonSerializable;
use Symfony\Component\Serializer\Serializer;

/**
 * A component bag you can use to store and retrieve values
 */
class Bag implements BagInterface
{
    public $serializer;

    /**
     * @param Serializer $serializer You can inject your own Serializer based on the Symfony one
     */
    public function __construct(Serializer $serializer = NULL)
    {
        $this->serializer = $serializer ? $serializer : new Serializer;
    }

    public function __set($name, $value)
    {
        $this->{$name} = $value;
    }

    public function __get($name)
    {
        return $this->{$name};
    }

    public function __call($name, $arguments)
    {
        return $this->__get($name)($arguments);
    }
}
