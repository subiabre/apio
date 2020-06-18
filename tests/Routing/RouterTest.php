<?php

namespace Apio\Tests\Routing;

use Apio\Routing\Router;
use FastRoute\Dispatcher;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RouterTest extends TestCase
{
    public function testTakesRequestAndResponseInstancesOnConstructor()
    {
        $router = new Router(new Request, new Response);

        $this->assertObjectHasAttribute('request', $router);
        $this->assertObjectHasAttribute('response', $router);
    }

    public function testMakesDefaultInstancesOnConstructor()
    {
        $router = new Router();

        $this->assertObjectHasAttribute('request', $router);
        $this->assertObjectHasAttribute('response', $router);

        $this->assertInstanceOf(Request::class, $router->request);
        $this->assertInstanceOf(Response::class, $router->response);
    }

    public function testBuildDispatcher()
    {
        $router = new Router();
        $dispatcher = $router->buildDispatcher();

        $this->assertInstanceOf(Dispatcher::class, $dispatcher);
    }
}
