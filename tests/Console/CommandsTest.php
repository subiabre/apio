<?php declare(strict_types=1);

namespace Apio\Tests\Console;

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
