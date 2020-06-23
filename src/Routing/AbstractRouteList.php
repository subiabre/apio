<?php

namespace Apio\Routing;

use Symfony\Component\HttpFoundation\Request;

/**
 * Abstract for the RouteList classes
 */
abstract class AbstractRouteList extends RouteList
{
    /**
     * Method to be called when the Request matches a route path with an invalid method
     * @param Request $request Request object passed by the Router
     * @param array $methods List of allowed methods passed by the Router
     */
    abstract public function methodNotAllowed(Request $request, array $methods): Response;

    /**
     * Method to be called when the Request does not match any route
     * @param Request $request Request object passed by the Router
     */
    abstract public function routeNotFound(Request $request): Response;

    /**
     * Add your routes inside this method
     * @param Request $request Request object passed by the Router
     */
    abstract public function routes(Request $request): void;
}
