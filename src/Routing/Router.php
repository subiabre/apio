<?php

namespace Apio\Routing;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Router
{
    public $request;

    public $response;

    /**
     * @param Request $request The Request instance to be used by the Router
     * @param Response $response The Response instance to be used by the Router
     */
    public function __construct(Request $request = NULL, Response $response = NULL)
    {
        $this->request = $request ? $request : new Request();
        $this->response = $response ? $response : new Response();
    }
}
