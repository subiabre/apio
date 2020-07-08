<?php

namespace Apio\Logging;

use Amp\Log\ConsoleFormatter;
use DateTime;
use DateTimeZone;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonologLogger;

/**
 * Extends the MonoLogger default logger to push a conveniently Amp-integrated log handler
 */
class Logger extends MonologLogger
{
    public const SIMPLE_DATE_FORMAT = "Y-m-d\TH:i:s";

    /**
     * @param string             $name       The logging channel, a simple descriptive name that is attached to all log records
     * @param HandlerInterface[] $handlers   Optional stack of handlers, the first one in the array is called first, etc.
     * @param callable[]         $processors Optional array of processors
     * @param DateTimeZone|null  $timezone   Optional timezone, if not provided date_default_timezone_get() will be used
     */
    public function __construct(string $name, array $handlers = [], array $processors = [], ?DateTimeZone $timezone = null)
    {
        parent::__construct($name, $handlers, $processors, $timezone);

        $ampHandler = new StreamHandler(\STDOUT);
        $ampHandler->setFormatter(new ConsoleFormatter(
            ConsoleFormatter::SIMPLE_FORMAT,
            self::SIMPLE_DATE_FORMAT,
            false,
            true
        ));

        $this->pushHandler($ampHandler);
    }
}
