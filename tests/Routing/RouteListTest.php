<?php

namespace Apio\Tests\Routing;

use Apio\Routing\Response;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use TypeError;

class RouteListTest extends TestCase
{
    public function testBuildsRoutes()
    {
        $routeList = new RouteListMock;
        $routeList->routes();

        $this->assertIsArray($routeList->routeList);

        foreach ($routeList->routeList as $route) {
            $this->assertIsArray($route);
            $this->assertArrayHasKey('method', $route);
            $this->assertArrayHasKey('path', $route);
            $this->assertArrayHasKey('handler', $route);

            $this->assertIsString($route['method']);
            $this->assertIsString($route['path']);
            $this->assertIsCallable($route['handler']);
        }
    }

    public function testRoutesCanBeAddedAfterInstantiation()
    {
        $routeList = new RouteListMock;
        
        $routeList->get('/new', fn() => new Response());
        $routeList->routes();

        $expected = [
            'method' => 'GET',
            'path' => '/new',
            'handler' => fn() => new Response()
        ];

        $this->assertEquals($expected, $routeList->routeList[0]);
    }

    public function testAllRoutesReturnResponse()
    {
        $routeList = new RouteListMock;
        $routeList->routes();

        $this->expectException(TypeError::class);

        foreach ($routeList->routeList as $route) {
            $response = $route['handler'](new Request);

            $this->assertInstanceOf(Response::class, $response);
        }        
    }

    public function testHandlersGetPassedRequest()
    {
        $routeList = new RouteListMock;
        $routeList->routes();

        $request = Request::createFromGlobals();
        $response = $routeList->routeList[0]['handler']($request);
        $actual = $response->request;

        $this->assertSame($request, $actual);
    }
}
