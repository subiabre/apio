<?php

namespace Apio\Tests\Routing;

use PHPUnit\Framework\TestCase;

class RoutesLoaderTest extends TestCase
{
    public function testRoutesMakesList()
    {
        $routes = new RoutesLoaderMock;
        $routes->routes();

        $this->assertNotTrue(empty($routes->routeList));
    }
}
