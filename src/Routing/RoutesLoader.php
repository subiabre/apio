<?php

namespace Apio\Routing;

abstract class RoutesLoader extends RouterCore implements RoutesLoaderInterface
{
    /**
     * Add new routes inside this function
     */
    abstract public function routes(): void;
}
