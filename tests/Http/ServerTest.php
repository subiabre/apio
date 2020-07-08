<?php

namespace Apio\Tests\Http;

use Amp\Socket\Server as SocketServer;
use Apio\Http\Server;
use Apio\Routing\Router;
use PHPUnit\Framework\TestCase;

class ServerTest extends TestCase
{
    public function testListenReturnsSocket()
    {
        $server = new Server;
        $router = new Router;

        $listen = $server->listen(3000, $router);

        $this->assertInstanceOf(SocketServer::class, $listen);
    }
}
