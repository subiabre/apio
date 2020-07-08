<?php

namespace Apio\Http;

use Amp\Http\Server\HttpServer;
use Amp\Loop;

/**
 * Provides the API to run the server on loop
 */
class Listener
{
    /**
     * @var HttpServer
     */
    public $http;

    public function __construct(HttpServer $httpServer)
    {
        $this->http = $httpServer;
    }

    /**
     * Run the Amp server in loop
     * @param callable $fn Handler function to be run inside the Amp loop
     */
    public function run(callable $fn)
    {
        Loop::run(function() use ($fn) {
            yield $this->http->start();

            // Stop the server when SIGINT is received (this is technically optional, but it is best to call Server::stop()).
            Loop::onSignal(SIGINT, function (string $watcherId) use ($fn) {
                Loop::cancel($watcherId);
                yield $this->http->stop();

                $fn();

                echo PHP_EOL;
            });
        });
    }
}
