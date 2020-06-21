<?php

namespace Apio\Routing;

interface RoutesLoaderInterface
{
    public function getRouter(): Router;
    public function routes(): void;
}
