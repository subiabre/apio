<?php

namespace Apio\Tests\Routing;

use PHPUnit\Framework\TestCase;

class ControllerTest extends TestCase
{
    public function testRoutesCanAccessInternalObjects()
    {
        $controller = new ControllerMock();
        $controller->routes();

        $handler = $controller->routeList[0]['handler']();

        $this->assertSame($controller->getSerializer(), $handler);
    }
}
