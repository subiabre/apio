<?php

namespace Apio\Tests\Routing;

use Amp\Http\Server\Router as HttpRouter;
use Apio\Http\Response;
use Apio\Routing\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase{
    public function testGetsPassedAmpRouter()
    {
        $ampRouter = new HttpRouter;
        $router = new Router($ampRouter);

        $this->assertSame($ampRouter, $router->routes);
    }

    public function testRouteAdditionIsChainable()
    {
        $router = new Router();

        $delete = $router
            ->get('/testGet', fn() => new Response())
            ->post('/testPost', fn() => new Response())
            ->put('/testPut', fn() => new Response())
            ->delete('/testDelete', fn() => new Response());

        $this->assertInstanceOf(Router::class, $delete);
    }
}
