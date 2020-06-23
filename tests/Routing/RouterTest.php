<?php

namespace Apio\Tests\Routing;

use Apio\Routing\AbstractRouteList;
use Apio\Routing\Response;
use Apio\Routing\Router;
use FastRoute\Dispatcher;
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

    public function testTakesRouteList()
    {
        $router = new Router();
        $routeList = new RouteListMock;

        $router->use($routeList);
 
        $routerRouteList = $router->getRouteList();

        $this->assertInstanceOf(AbstractRouteList::class, $routerRouteList);
        $this->assertSame($routeList, $routerRouteList);
    }

    public function testBuildsDispatcher()
    {
        $router = new Router();
        $routeList = new RouteListMock;

        $router->use($routeList);

        $dispatcher = $router->buildDispatcher();

        $this->assertInstanceOf(Dispatcher::class, $dispatcher);
    }

    public function testListenDispatchesMethodNotAllowed()
    {
        $request = Request::create(
            '/',
            'POST'
        );

        $response = (new Response)
            ->error(['message' => 'Method not allowed'])
            ->error(['methods' => ['GET']]);

        $router = new Router($request);
        $routeList = new RouteListMock;

        $router->use($routeList);

        $dispatched = $router->listen();

        $this->assertEquals($response, $dispatched);
    }

    public function testListenDispatchesRouteNotFound()
    {
        $request = Request::create(
            '/route not found',
            'GET'
        );

        $response = (new Response)
            ->error(['message' => 'Route not found']);

        $router = new Router($request);
        $routeList = new RouteListMock;

        $router->use($routeList);

        $dispatched = $router->listen();

        $this->assertEquals($response, $dispatched);
    }

    public function testListenDispatchesMatchingRoute()
    {
        $request = Request::create(
            '/test',
            'GET'
        );

        $response = new Response;

        $router = new Router($request);
        $routeList = new RouteListMock;

        $router->use($routeList);

        $dispatched = $router->listen();

        $this->assertEquals($response, $dispatched);
    }
}
