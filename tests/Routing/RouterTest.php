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
        $router = new Router(new Request, new Response);

        $this->assertObjectHasAttribute('request', $router);
        $this->assertObjectHasAttribute('response', $router);
    }
}
