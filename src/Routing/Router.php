<?php

namespace Apio\Routing;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    public $request;

    public $response;

    /**
     * @param string $requestClass The classname of the Request objects
     * @param string $responseClass The classname of the Response objects
     */
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }
}
