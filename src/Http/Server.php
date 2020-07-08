<?php

namespace Apio\Http;

use Amp\Http\Server\HttpServer;
use Amp\Http\Server\RequestHandler;
use Amp\Socket\Server as SocketServer;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Wrap the amphp/http-server class into a convenient API
 */
class Server
{
    /**
     * Get an Amp server instance with a single socket
     * @param string $address Port number to bind the server socket to
     * @param RequestHandler $router Instance of router
     * @return Listener
     */
    public function listen(string $address, RequestHandler $router, LoggerInterface $logger = NULL): Listener
    {
        $sockets = [SocketServer::listen($address)];
        $logger = $logger ? $logger : new NullLogger;

        $server = new HttpServer($sockets, $router, $logger);

        return new Listener($server);
    }
}
