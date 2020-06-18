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
                
                $res = $handler($this->request, $this->response);
                $res->send();
                
                break;
        }
    }
}
