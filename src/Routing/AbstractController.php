<?php

namespace Apio\Routing;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

abstract class AbstractController extends AbstractRoutesLoader
{
    /**
     * @var Serializer
     */
    protected $serializer;

    public function __construct(SerializerInterface $serializer = NULL)
    {
        $this->serializer = $serializer ?: new Serializer(
            [new ObjectNormalizer],
            [new JsonEncoder]
        );
    }

    /**
     * Obtain the serializer instance
     * @return SerializerInterface
     */
    public function getSerializer(): SerializerInterface
    {
        return $this->serializer;
    }
}
