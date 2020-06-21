<?php

namespace Apio\Routing;

abstract class AbstractRoutesLoader extends RouterCore implements RoutesLoaderInterface
{
    /**
     * Add new routes inside this function
     */
    abstract public function routes(): void;
}
