<?php

namespace Apio\Console;

/**
 * Contains the list of commands available to the console
 */
class AppCommands
{
    public function getCommands(): array
    {
        return [
            new PHPUnit(),
            new Server()
        ];
    }
}
