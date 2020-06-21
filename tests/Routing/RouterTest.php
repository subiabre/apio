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

    public function testAddsRoutesToTheList()
    {
        $router = new Router();
        
        $router->addRoute('GET', '/', fn() => 'OK');

        $this->assertIsArray($router->routeList);
        $this->assertSame('GET', $router->routeList[0]['method']);
        $this->assertSame('/', $router->routeList[0]['path']);
        $this->assertSame('OK', $router->routeList[0]['handler']());
    }

    public function testUseController()
    {
        $router = new Router();

        $router->use(new MockRoutesLoader);

        $this->assertSame(1, \count($router->routeList));
        $this->assertSame('GET', $router->routeList[0]['method']);
        $this->assertSame('/test', $router->routeList[0]['path']);
        $this->assertSame('OK', $router->routeList[0]['handler']());
    }
}
