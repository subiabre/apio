<?php

namespace Apio\Routing;

abstract class RoutesLoader implements RoutesLoaderInterface
{
    public $router;

    public function __construct()
    {
        $this->router = $this->getRouter();  
    }

    /**
     * Return a new router instance
     * @return Router
     */
    public function getRouter(): \Apio\Routing\Router
    {
        return new Router();
    }

    /**
     * Add new routes using the internal router instance
     */
    abstract public function routes(): void;
}
