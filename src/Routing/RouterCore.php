<?php

namespace Apio\Routing;

class RouterCore
{
    public $routeList = [];

    /**
     * Add a new route to listen for
     * @param string $method HTTP verb
     * @param string $path An URI to be matched against
     * @param callable $fn The handler function to be executed
     */
    public function addRoute(string $method, string $path, callable $fn)
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
