<?php

namespace Apio\Tests\Routing;

use Apio\Routing\Router;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class RouterTest extends TestCase
{
    public function testTakesRequestOnConstruct()
    {
        $request = Request::createFromGlobals();
        $router = new Router($request);

        $this->assertObjectHasAttribute('request', $router);
        $this->assertInstanceOf(Request::class, $request);
    }

    public function testMakesRequestOnConstruct()
    {
        $request = Request::createFromGlobals();
        $router = new Router();

        $this->assertEquals($request, $router->request);
    }
}
