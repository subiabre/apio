<?php

namespace Apio\Tests\Http;

use Apio\Http\Response;
use Apio\Http\Server;
use Apio\Routing\Router;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class ServerTest extends TestCase
{
    public function testListenReturnsResponse()
    {
        $server = new Server;
        $router = new Router;
        $response = new Response;

        $router->get('/', function(Request $request) use ($response){
            return $response;
        });

        $serverResponse = $server->listen(['0.0.0.0:3000'], $router);

        $this->assertSame($response, $serverResponse);
    }
}
