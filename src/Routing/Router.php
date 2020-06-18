<?php

namespace Apio\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use function FastRoute\simpleDispatcher;

class Router
{
    public $request;

    public $response;

    public $routeList = [];

    /**
     * @param Request $request The Request instance to be used by the Router
     * @param Response $response The Response instance to be used by the Router
     */
    public function __construct(Request $request = NULL, Response $response = NULL)
    {
        $this->request = $request ? $request : new Request();
        $this->response = $response ? $response : new JsonResponse();

        $this->request = $this->request::createFromGlobals();
    }

    /**
     * Generate the routes dispatcher from the routes \
     * Auto-called on `listen()`
     * @return Dispatcher
     */
    public function buildDispatcher() : Dispatcher
    {
        $dispatcher = simpleDispatcher(function(RouteCollector $collector) {
            foreach ($this->routeList as $route)
            {
                $collector->addRoute(
                    $route['method'],
                    $route['path'],
                    $route['handler']
                );
            }
        });

        return $dispatcher;
    }
    
    /**
     * Builds routes dispatcher and handles the route matches
     */
    public function listen()
    {
        $dispatcher = $this->buildDispatcher();

        $match = $dispatcher->dispatch(
            $this->request->getMethod(),
            $this->request->getRequestUri()
        );

        switch ($match[0]) {
            case Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $match[1];
                // ... 405 Method Not Allowed
                break;
            case Dispatcher::FOUND:
                $handler = $match[1];
                $vars = $match[2];
                
                $this->request->query->add($vars);

                $res = $handler($this->request, $this->response);
                $res->send();
                
                break;
        }
    }

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
