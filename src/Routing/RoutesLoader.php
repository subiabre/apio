<?php

namespace Apio\Routing;

abstract class RoutesLoader extends Router implements RoutesLoaderInterface
{
    /**
     * Add new routes using the internal router instance
     */
    abstract public function routes(): void;
}
