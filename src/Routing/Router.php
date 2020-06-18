<?php

namespace Apio\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

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
    public function __construct(HttpRequest $request = NULL, HttpResponse $response = NULL)
    {
        $this->request = $request ? $request : new HttpRequest();
        $this->response = $response ? $response : new Response();

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
                
                $this->response->error($this->response::NOT_FOUND_MESSAGE);
                $this->response->send();

                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $match[1];

                $this->response->error($this->response::METHOD_NOT_ALLOWED_MESSAGE);
                $this->response->error(['methods' => $allowedMethods]);
                $this->response->send();

                break;
            case Dispatcher::FOUND:
                $handler = $match[1];
                $vars = $match[2];

                $handler($this->request, $this->response, $vars);
                
                break;
        }
    }

    /**
     * Import routes from a controller class
     * @param Controller $controller Controller class with the routes defined inside `routes()`
     */
    public function use(Controller $controller)
    {
        $controller->routes();

        $this->routeList = \array_merge($this->routeList, $controller->router->routeList);
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
