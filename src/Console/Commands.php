<?php declare(strict_types=1);

namespace Apio\Console;

/**
 * Contains the list of commands available to the console
 */
class Commands
{
    public function getCommands(): array
    {
        return [
            new Test()
        ];
    }
}
