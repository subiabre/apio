<?php

namespace Apio\Test\Console;

use Apio\Console\Commands;
use PHPUnit\Framework\TestCase;

class CommandsTest extends TestCase
{
    public function testReturnsArray()
    {
        $commands = (new Commands)->getCommands();

        $this->assertIsArray($commands);
        
        foreach($commands as $command)
        {
            $this->assertIsObject($command);
        }
    }
}
