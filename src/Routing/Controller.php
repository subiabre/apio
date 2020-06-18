<?php

namespace Apio\Routing;

class Controller implements ControllerInterface
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
    public function routes(): void
    {}
}
