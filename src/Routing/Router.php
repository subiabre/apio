<?php

namespace Apio\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

use function FastRoute\simpleDispatcher;

class Router extends RouterCore
{
    public $request;

    public $response;
    
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
     * @return Response Response object
     */
    public function listen(): HttpResponse
    {
        $dispatcher = $this->buildDispatcher();

        $match = $dispatcher->dispatch(
            $this->request->getMethod(),
            $this->request->getRequestUri()
        );

        switch ($match[0]) {
            default:
                $this->response->error($this->response::NOT_FOUND_MESSAGE);

                return $this->response;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $match[1];

                $this->response->error($this->response::METHOD_NOT_ALLOWED_MESSAGE);
                $this->response->error(['methods' => $allowedMethods]);

                return $this->response;
            case Dispatcher::FOUND:
                $handler = $match[1];
                $vars = $match[2];

                $this->request->query->add($vars);

                return $handler($this->request, $this->response);
        }
    }

    /**
     * Import routes from a routes loader class
     * @param RoutesLoader $routes Routes loader class with the routes defined inside `routes()`
     */
    public function use(RoutesLoaderInterface $routes)
    {
        $routes->routes();

        $this->routeList = \array_merge($this->routeList, $routes->routeList);
    }
}
