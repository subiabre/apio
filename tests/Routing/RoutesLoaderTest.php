<?php

namespace Apio\Tests\Routing;

use Apio\Routing\Router;
use PHPUnit\Framework\TestCase;

class RoutesLoaderTest extends TestCase
{
    public function testRoutesMakesList()
    {
        $routes = new MockRoutesLoader;
        $routes->routes();

        $this->assertNotTrue(empty($routes->routeList));
    }
}
