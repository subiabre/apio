<?php

namespace Apio\Routing;

class Router
{
    public $requestClass;

    public $responseClass;

    public function __construct(string $requestClass, string $responseClass)
    {
        $this->requestClass = $requestClass;
        $this->responseClass = $responseClass;
    }
}
