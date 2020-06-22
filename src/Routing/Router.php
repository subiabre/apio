<?php

namespace Apio\Routing;

use Symfony\Component\HttpFoundation\Request;

/**
 * Takes a Request object and dispatches it
 * @author Subiabre
 */
class Router
{
    public $request;

    public function __construct(Request $request = NULL)
    {
        if (!$request) $request = Request::createFromGlobals();

        $this->request = $request;
    }
}
