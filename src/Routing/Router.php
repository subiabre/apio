<?php

namespace Apio\Routing;

use Amp\Http\Server\RequestHandler;
use Amp\Http\Server\RequestHandler\CallableRequestHandler;
use Amp\Http\Server\Router as ServerRouter;

/**
 * Add functionality to Amp Router
 * @inheritdoc
 */
class Router implements RouterInterface
{
    /**
     * @var ServerRouter
     */
    public $routes;

    public function __construct(RequestHandler $requestHandler = NULL)
    {
        $requestHandler = $requestHandler ? $requestHandler : new ServerRouter();

        $this->routes = $requestHandler;
    }
    
    /**
     * Add a GET matching route
     * @param string $uri
     * @param callable $fn Handler function
     */
    public function get(string $uri, callable $fn)
    {
        $this->routes->addRoute('GET', $uri, new CallableRequestHandler($fn));
    }

    /**
     * Add a POST matching route
     * @param string $uri
     * @param callable $fn Handler function
     */
    public function post(string $uri, callable $fn)
    {
        $this->routes->addRoute('POST', $uri, new CallableRequestHandler($fn));
    }

    /**
     * Add a PUT matching route
     * @param string $uri
     * @param callable $fn Handler function
     */
    public function put(string $uri, callable $fn)
    {
        $this->routes->addRoute('PUT', $uri, new CallableRequestHandler($fn));
    }

    /**
     * Add a DELETE matching route
     * @param string $uri
     * @param callable $fn Hanlder function
     */
    public function delete(string $uri, callable $fn)
    {
        $this->routes->addRoute('DELETE', $uri, new CallableRequestHandler($fn));
    }
}
