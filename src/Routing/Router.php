<?php

namespace Apio\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Symfony\Component\HttpFoundation\Request;

use function FastRoute\simpleDispatcher;

/**
 * Takes a Request object and dispatches it
 * @author Subiabre
 */
class Router
{
    /**
     * The Request handler object instance
     * @var Request
     */
    public $request;

    /**
     * @var AbstractRouteList
     */
    protected $routes;
    
    /**
     * @param Request $request Request handler object
     */
    public function __construct(Request $request = NULL)
    {
        if (!$request) $request = Request::createFromGlobals();

        $this->request = $request;
    }

    /**
     * Use an instance of route list
     * @param AbstractRouteList $routeList Instance of route list
     */
    public function use(AbstractRouteList $routeList)
    {
        $this->routes = $routeList;
    }

    /**
     * Get the route list object
     * @return AbstractRouteList
     */
    public function getRouteList(): AbstractRouteList
    {
        return $this->routes;
    }

    /**
     * Generate the routes dispatcher from the routes \
     * Auto-called on `listen()`
     * @return Dispatcher
     */
    public function buildDispatcher() : Dispatcher
    {
        $this->routes->routes($this->request);
        $list = $this->routes->routeList;

        $dispatcher = simpleDispatcher(function(RouteCollector $collector) use ($list) {
            foreach ($list as $route)
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
     * Dispatch routes
     * @return Response
     */
    public function listen(): Response
    {
        $dispatcher = $this->buildDispatcher();

        $match = $dispatcher->dispatch(
            $this->request->getMethod(),
            $this->request->getRequestUri()
        );

        switch ($match[0]) {
            default:
                
                $response = $this->routes
                    ->routeNotFound($this->request);

                return $response;
                
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $match[1];
                
                $response = $this->routes
                    ->methodNotAllowed($this->request, $allowedMethods);

                return $response;

            case Dispatcher::FOUND:
                $handler = $match[1];
                $vars = $match[2];

                $this->request->query->add($vars);

                $response = $handler($this->request);

                return $response;
        }
    }
}
