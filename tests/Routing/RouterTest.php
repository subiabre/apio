<?php declare(strict_types=1);

namespace Apio\Tests\Routing;

use Apio\Routing\AbstractRouteList;
use Apio\Routing\Response;
use Apio\Routing\RouteList;
use Apio\Routing\Router;
use Apio\Storage\Bag;
use FastRoute\Dispatcher;
use FastRoute\Route;
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

    public function testTakesManyRouteLists()
    {
        $router = new Router();
        $routeList1 = new RouteListMock;
        $routeList1->get('/newRoute1', fn() => new Response);
        $routeList2 = new RouteListMock;
        $routeList2->get('/newRoute2', fn() => new Response);

        $router
            ->use($routeList1)
            ->use($routeList2);

        $this->assertInstanceOf(AbstractRouteList::class, $router->getRouteList());
        $this->assertNotSame($routeList1->routeList, $router->routeList);
        $this->assertNotSame($routeList2->routeList, $router->routeList);
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
            ->error(['message' => 'Route request method not allowed.'])
            ->error(['methods' => ['GET']]);

        $router = new Router($request);
        $routeList = new RouteList;
        $routeList->get('/', fn() => new Response);

        $router->use($routeList);

        $dispatched = $router->dispatch();

        $this->assertEquals($response, $dispatched);
    }

    public function testListenDispatchesRouteNotFound()
    {
        $request = Request::create(
            '/route not found',
            'GET'
        );

        $response = (new Response)
            ->error(['message' => 'Route not found.']);

        $router = new Router($request);
        $routeList = new RouteList;

        $router->use($routeList);

        $dispatched = $router->dispatch();

        $this->assertEquals($response, $dispatched);
    }

    public function testDispatchDispatchesMatchingRoute()
    {
        $request = Request::create(
            '/test',
            'GET'
        );

        $response = new Response;

        $router = new Router($request);
        $routeList = new RouteListMock;

        $router->use($routeList);

        $dispatched = $router->dispatch();

        $this->assertEquals($response, $dispatched);
    }

    public function testHandlersGetPassedRequestAndResponse()
    {
        $request =  $request = Request::create(
            '/',
            'GET'
        );

        $router = new Router($request);
        $routeList = new RouteListMock;

        $router->use($routeList);

        $dispatched = $router->dispatch();

        $this->assertInstanceOf(Request::class, $dispatched->requestObj);
        $this->assertInstanceOf(Response::class, $dispatched->responseObj);
    }

    public function testHandlerGetsPassedDynamicParameters()
    {
        $request =  $request = Request::create(
            '/testHandlerParams',
            'GET'
        );
        $router = new Router($request);

        $router->get('/testHandlerParams', function(Response $response, Bag $bag) {
            $response->bag = $bag;

            return $response;
        });

        $dispatched = $router->dispatch();

        $this->assertInstanceOf(Bag::class, $dispatched->bag);
    }
}
