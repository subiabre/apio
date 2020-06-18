<?php

namespace Apio\Tests\Routing;

use Apio\Routing\Router;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RouterTest extends TestCase
{
    public function testTakesRequestAndResponseClassesOnConstructor()
    {
        $router = new Router(Request::class, Response::class);

        $this->assertObjectHasAttribute('requestClass', $router);
        $this->assertObjectHasAttribute('responseClass', $router);

        $this->assertSame(Request::class, $router->requestClass);
        $this->assertSame(Response::class, $router->responseClass);
    }
}
