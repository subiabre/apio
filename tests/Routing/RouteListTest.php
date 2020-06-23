<?php

namespace Apio\Tests\Routing;

use Apio\Routing\Response;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class RouteListTest extends TestCase
{
    public function testBuildsRoutes()
    {
        $routeList = new RouteListMock;
        $routeList->routes(new Request());

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
        $routeList->routes(new Request());

        $expected = [
            'method' => 'GET',
            'path' => '/new',
            'handler' => fn() => new Response()
        ];

        $this->assertEquals($expected, $routeList->routeList[0]);
    }
}
