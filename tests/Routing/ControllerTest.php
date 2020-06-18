<?php

namespace Apio\Tests\Routing;

use Apio\Routing\Controller;
use Apio\Routing\Router;
use PHPUnit\Framework\TestCase;

class ControllerTest extends TestCase
{
    public function testInstanceHasEmptyRouter()
    {
        $controller = new Controller;
        $router = $controller->getRouter();

        $this->assertInstanceOf(Router::class, $router);
        $this->assertTrue(empty($router->routeList));
    }
}
