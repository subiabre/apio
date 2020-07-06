<?php declare(strict_types=1);

namespace Apio\Routing;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Symfony\Component\HttpFoundation\Request;

use function FastRoute\simpleDispatcher;

/**
 * Takes a Request object and dispatches it
 * @author Subiabre
 */
class Router extends RouteList
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
     * @return self
     */
    public function use(AbstractRouteList $routeList): self
    {
        $this->routes = $routeList;

        $routeList->routes($this->request);

        $this->routeList = \array_merge($this->routeList, $routeList->routeList);

        return $this;
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
     * Dispatch routes
     * @return Response
     * @throws BadRouteException
     */
    public function dispatch(): Response
    {
        $dispatcher = $this->buildDispatcher();

        $match = $dispatcher->dispatch(
            $this->request->getMethod(),
            $this->request->getRequestUri()
        );

        switch ($match[0]) {
            default:
                
                $response = $this->routes ? $this->routes : $this;
                
                return $response->routeNotFound($this->request);
                
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $match[1];
                
                $response = $this->routes ? $this->routes : $this;
                
                return $response->methodNotAllowed($this->request, $allowedMethods);

            case Dispatcher::FOUND:
                $handler = $match[1];
                $handlerParams = $this->getHandlerParams($handler);
                $vars = $match[2];

                $this->request->query->add($vars);
                $handlerParams[0] = $this->request;

                $response = \call_user_func_array($handler, $handlerParams);

                return $response;
        }
    }
}
