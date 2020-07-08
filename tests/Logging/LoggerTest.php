<?php

namespace Apio\Tests\Logging;

use Apio\Logging\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Test\TestCase;

class LoggerTest extends TestCase
{
    public function testLoggerHasDefaultLogHandler()
    {
        $logger = new Logger('server');

        $handlers = $logger->getHandlers();

        $this->assertInstanceOf(StreamHandler::class, $handlers[0]);
    }
}
