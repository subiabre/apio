<?php

namespace Apio\Component;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * A component bag you can use to store and retrieve values
 */
class Bag implements BagInterface
{
    public $serializer;

    protected $bag;

    /**
     * @param Serializer $serializer You can inject your own Serializer based on the Symfony one
     */
    public function __construct(Serializer $serializer = NULL)
    {
        $this->serializer = $serializer ? $serializer : $this->getDefaultSerializer();
    }

    /**
     * Return the default bag Symfony serializer
     */
    protected function getDefaultSerializer(): Serializer
    {
        return new Serializer(
            [new ObjectNormalizer], 
            [new JsonEncoder()]
        );
    }

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
        return $this->bag[$name];
    }

    public function __call($name, $arguments)
    {
        return $this->__get($name)($arguments);
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
