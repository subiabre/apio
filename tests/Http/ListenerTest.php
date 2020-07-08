<?php

namespace Apio\Tests\Http;

use Amp\Http\Server\HttpServer;
use Apio\Http\Listener;
use Apio\Http\Server;
use Apio\Routing\Router;
use PHPUnit\Framework\TestCase;

class ListenerTest extends TestCase{
    public function testHttpServerProperty()
    {
        $this->assertClassHasAttribute('http', Listener::class);
    }

    public function testGetsHttpServer()
    {
        $server = new Server;
        $router = new Router();
        $listener = $server->listen('localhost:4000', $router);

        $this->assertInstanceOf(HttpServer::class, $listener->http);
    }
}
