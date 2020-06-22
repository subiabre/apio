<?php

namespace Apio\Tests\Routing;

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
        
        $router->addRoute('GET', '/', fn() => 'OK');
        $router->get('/get', fn() => 'OK');
        $router->post('/post', fn() => 'OK');
        $router->put('/put', fn() => 'OK');
        $router->delete('/delete', fn() => 'OK');

        $this->assertIsArray($router->routeList);
        $this->assertSame('GET', $router->routeList[0]['method']);
        $this->assertSame('/', $router->routeList[0]['path']);
        $this->assertSame('OK', $router->routeList[0]['handler']());

        foreach ($router->routeList as $key => $route) {
            $this->assertSame($route['method'], $router->routeList[$key]['method']);
            $this->assertSame($route['path'], $router->routeList[$key]['path']);
            $this->assertSame($route['handler'](), $router->routeList[$key]['handler']());
        }
    }

    public function testUseRoutesLoader()
    {
        $router = new Router();

        $router->use(new RoutesLoaderMock);

        $this->assertSame(1, \count($router->routeList));
        $this->assertSame('GET', $router->routeList[0]['method']);
        $this->assertSame('/test', $router->routeList[0]['path']);
        $this->assertSame('OK', $router->routeList[0]['handler']());
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
}
