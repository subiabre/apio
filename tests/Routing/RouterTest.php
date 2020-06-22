<?php

namespace Apio\Tests\Routing;

use Apio\Routing\Response as RoutingResponse;
use Apio\Routing\Router;
use FastRoute\Dispatcher;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

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
        
        $router->addRoute('CONNECT', '/', fn(): Response => new Response());
        $router->get('/', fn(): Response => new Response());
        $router->post('/', fn(): Response => new Response());
        $router->put('/', fn(): Response => new Response());
        $router->delete('/', fn(): Response => new Response());

        $this->assertIsArray($router->routeList);

        $this->assertSame('CONNECT', $router->routeList[0]['method']);
        $this->assertSame('GET', $router->routeList[1]['method']);
        $this->assertSame('POST', $router->routeList[2]['method']);
        $this->assertSame('PUT', $router->routeList[3]['method']);
        $this->assertSame('DELETE', $router->routeList[4]['method']);
    }

    public function testUseRoutesLoader()
    {
        $router = new Router();

        $router->use(new RoutesLoaderMock);

        $this->assertSame(1, \count($router->routeList));
        $this->assertSame('GET', $router->routeList[0]['method']);
        $this->assertSame('/test', $router->routeList[0]['path']);
        $this->assertInstanceOf(Response::class, $router->routeList[0]['handler']());
    }

    public function testUseController()
    {
        $router = new Router();

        $router->use(new ControllerMock());

        $this->assertSame(1, \count($router->routeList));
        $this->assertSame('GET', $router->routeList[0]['method']);
        $this->assertSame('/test', $router->routeList[0]['path']);
        $this->assertInstanceOf(SerializerInterface::class, $router->routeList[0]['handler']());
    }

    public function testListenDispatchesMatchingRequests()
    {
        $request = Request::create(
            '/test',
            'GET'
        );

        $response = new RoutingResponse();

        $router = new Router($request);
        $router->use(new RoutesLoaderMock);

        $dispatched = $router->listen();

        $this->assertEquals($response, $dispatched);
    }
}
