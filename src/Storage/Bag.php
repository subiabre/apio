<?php

namespace Apio\Storage;

/**
 * A component bag you can use to store and retrieve values
 */
class Bag implements BagInterface
{
    protected $bag = [];

    /**
     * Obtain a bag array without the given keys
     * @param array $ignore Keys to be ignored
     * @return array
     */
    protected function ignoreKeys(array $ignore): array
    {
        foreach($ignore as $key => $name)
        {
            $ignore[$name] = NULL;
        }

        return \array_diff_key($this->bag, $ignore);
    }

    public function __set($name, $value)
    {
        $this->bag[$name] = $value;
    }

    public function __get($name)
    {
        if (\array_key_exists($name, $this->bag)) {
            return $this->bag[$name];
        }

        return NULL;
    }

    public function __call($name, $arguments)
    {
        if (\array_key_exists($name, $this->bag) 
            && is_callable($this->bag[$name])) 
        {
            return $this->__get($name)($arguments);
        }

        return NULL;
    }

    /**
     * Obtain current bag data array
     * @param array $ignore Properties to be ignored
     * @return string 
     */
    public function toArray(array $ignore = []): array
    {
        return $this->ignoreKeys($ignore);
    }
}
