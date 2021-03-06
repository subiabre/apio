<?php

namespace Apio\Tests\Http;

use Apio\Http\Listener;
use Apio\Http\Server;
use Apio\Routing\Router;
use PHPUnit\Framework\TestCase;

class ServerTest extends TestCase
{
    public function testListenReturnsSelfAndUpdatesSocket()
    {
        $server = new Server;
        $router = new Router;

        $listen = $server->listen('localhost:3000', $router);

        $this->assertInstanceOf(Listener::class, $listen);
    }
}
