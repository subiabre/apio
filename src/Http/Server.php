<?php

namespace Apio\Http;

use Amp\Http\Server\HttpServer;
use Amp\Socket\Server as SocketServer;
use Apio\Routing\Router;
use Psr\Log\NullLogger;

/**
 * Wrap the amphp/http-server class into a convenient API
 */
class Server
{
    /**
     * Get an Amp server instance with a single socket
     * @param string $address Port number to bind the server socket to
     * @param Router $router Instance of router
     * @return Server
     */
    public function listen(string $address, Router $router, NullLogger $logger = NULL): HttpServer
    {
        $sockets = [SocketServer::listen($address)];
        $logger = $logger ? $logger : new NullLogger;

        return new HttpServer($sockets, $router->routes, $logger);
    }
}
