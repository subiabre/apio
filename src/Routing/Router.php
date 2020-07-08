<?php

namespace Apio\Routing;

use Amp\Http\Server\RequestHandler\CallableRequestHandler as RequestHandler;
use Amp\Http\Server\Router as ServerRouter;
use Amp\Http\Server\ServerObserver;

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

    public function __construct(ServerObserver $requestHandler = NULL)
    {
        $requestHandler = $requestHandler ? $requestHandler : new ServerRouter();

        $this->routes = $requestHandler;
    }
    
    /**
     * Add a GET matching route
     * @param string $uri
     * @param callable $fn Handler function
     * @return self
     */
    public function get(string $uri, callable $fn): self
    {
        $this->routes->addRoute('GET', $uri, new RequestHandler($fn));

        return $this;
    }

    /**
     * Add a POST matching route
     * @param string $uri
     * @param callable $fn Handler function
     * @return self
     */
    public function post(string $uri, callable $fn): self
    {
        $this->routes->addRoute('POST', $uri, new RequestHandler($fn));

        return $this;
    }

    /**
     * Add a PUT matching route
     * @param string $uri
     * @param callable $fn Handler function
     * @return self
     */
    public function put(string $uri, callable $fn): self
    {
        $this->routes->addRoute('PUT', $uri, new RequestHandler($fn));

        return $this;
    }

    /**
     * Add a DELETE matching route
     * @param string $uri
     * @param callable $fn Hanlder function
     * @return self
     */
    public function delete(string $uri, callable $fn): self
    {
        $this->routes->addRoute('DELETE', $uri, new RequestHandler($fn));

        return $this;
    }
}
