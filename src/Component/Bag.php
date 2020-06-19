<?php

namespace Apio\Component;

/**
 * A component bag you can use to store and retrieve values
 */
class Bag implements BagInterface
{
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
