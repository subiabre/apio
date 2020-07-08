<?php

namespace Apio\Routing;

use Amp\Http\Server\RequestHandler\CallableRequestHandler as RequestHandler;
use Amp\Http\Server\RequestHandler as RequestHandlerInterface;
use Amp\Http\Server\Router as ServerRouter;

/**
 * Add functionality to Amp Router
 * @inheritdoc
 */
class Router implements RouterInterface, RequestHandlerInterface
{
    /**
     * @var ServerRouter
     */
    public $handler;

    public function __construct(ServerRouter $handler = NULL)
    {
        $handler = $handler ? $handler : new ServerRouter();

        $this->handler = $handler;
    }
    
    /**
     * Add a GET matching route
     * @param string $uri
     * @param callable $fn Handler function
     * @return self
     */
    public function get(string $uri, callable $fn): self
    {
        $this->handler->addRoute('GET', $uri, new RequestHandler($fn));

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
        $this->handler->addRoute('POST', $uri, new RequestHandler($fn));

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
        $this->handler->addRoute('PUT', $uri, new RequestHandler($fn));

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
        $this->handler->addRoute('DELETE', $uri, new RequestHandler($fn));

        return $this;
    }

    public function handleRequest(\Amp\Http\Server\Request $request): \Amp\Promise
    {
        return $this->handler->handleRequest($request);
    }
}
