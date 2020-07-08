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
     * Run the Amp server
     */
    public function run()
    {
        Loop::run(function() {
            yield $this->http->start();

            // Stop the server when SIGINT is received (this is technically optional, but it is best to call Server::stop()).
            Loop::onSignal(SIGINT, function (string $watcherId) {
                $this->http->getLogger()->notice("Server connection closed.", ['watcher' => $watcherId]);

                Loop::cancel($watcherId);
                yield $this->http->stop();

                echo PHP_EOL;
            });
        });
    }
}
