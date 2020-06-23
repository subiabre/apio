<?php

namespace Apio\Routing;

/**
 * Core for the RouteList classes
 */
class RouteList
{
    /**
     * Array containing the routes in a FastRoute compatible format
     * @var array
     */
    public $routeList = [];

    /**
     * Add a route matching any HTTP method
     * @param string $method HTTP verb
     * @param string $path Route to match
     * @param callable $fn Handler function
     * @return void
     */
    public function addRoute(string $method, string $path, callable $fn): void
    {
        \array_push($this->routeList, [
            'method' => $method,
            'path' => $path,
            'handler' => $fn
        ]);
    }

    /**
     * Add a new GET route
     * @param string $path An URI to be matched against
     * @param callable $fn The handler function to be executed
     */
    public function get(string $path, callable $fn)
    {
        $this->addRoute('GET', $path, $fn);
    }

    /**
     * Add a new POST route
     * @param string $path An URI to be matched against
     * @param callable $fn The handler function to be executed
     */
    public function post(string $path, callable $fn)
    {
        $this->addRoute('POST', $path, $fn);
    }

    /**
     * Add a new PUT route
     * @param string $path An URI to be matched against
     * @param callable $fn The handler function to be executed
     */
    public function put(string $path, callable $fn)
    {
        $this->addRoute('PUT', $path, $fn);
    }

    /**
     * Add a new DELETE route
     * @param string $path An URI to be matched against
     * @param callable $fn The handler function to be executed
     */
    public function delete(string $path, callable $fn)
    {
        $this->addRoute('DELETE', $path, $fn);
    }
}
