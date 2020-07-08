<?php

namespace Apio\Tests\Routing;

use Amp\Http\Server\Router as HttpRouter;
use Apio\Routing\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase{
    public function testGetsPassedAmpRouter()
    {
        $ampRouter = new HttpRouter;
        $router = new Router($ampRouter);

        $this->assertSame($ampRouter, $router->routes);
    }
}
