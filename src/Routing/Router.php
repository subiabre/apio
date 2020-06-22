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
    protected $routeList;
    
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
        $this->routeList = $routeList;
    }

    /**
     * Get the route list object
     * @return AbstractRouteList
     */
    public function getRouteList(): AbstractRouteList
    {
        return $this->routeList;
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
}
