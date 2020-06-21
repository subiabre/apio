<?php

namespace Apio\Tests\Routing;

use Apio\Routing\Router;
use PHPUnit\Framework\TestCase;

class RoutesLoaderTest extends TestCase
{
    public function testInstanceHasEmptyRouter()
    {
        $routes = new MockRoutesLoader;
        $router = $routes->getRouter();

        $this->assertInstanceOf(Router::class, $router);
        $this->assertTrue(empty($router->routeList));
    }

    public function testRoutesMakesList()
    {
        $controller = new MockRoutesLoader;
        $controller->routes();

        $this->assertNotTrue(empty($controller->router->routeList));
    }
}
