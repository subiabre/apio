<?php declare(strict_types=1);

namespace Apio\Routing;

use ReflectionFunction;
use Symfony\Component\HttpFoundation\Request;

/**
 * Abstract for the RouteList classes
 * @author Subiabre
 */
abstract class AbstractRouteList
{
    /**
     * Array containing the routes in a FastRoute compatible format
     * @var array
     */
    public $routeList = [];
    
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
     * This method will be called by the Router before trying to load any routes \
     * Any route added before this method is run will also be read by the Router
     */
    abstract public function routes(): void;

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

    /**
     * Get the handler parameters as an array
     * @param callable $handler The route handler function
     * @return array
     */
    public function getHandlerParams(callable $handler): array
    {
        $reflectionFn = new ReflectionFunction($handler);

        $parameters = $reflectionFn->getParameters();

        foreach ($parameters as $key => $param) {
            $parameters[$key] = (string) $param->getType();
        }

        return $parameters;
    }
}
