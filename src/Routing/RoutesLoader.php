<?php

namespace Apio\Routing;

abstract class RoutesLoader extends Router implements RoutesLoaderInterface
{
    public function __construct()
    {
        // It makes no sense to let inject Request and Response interfaces here
    }

    /**
     * Add new routes using the internal router instance
     */
    abstract public function routes(): void;
}
