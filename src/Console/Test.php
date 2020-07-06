<?php declare(strict_types=1);

namespace Apio\Console;

use PHPUnit\TextUI\Command as TextUICommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Run PHPUnit
 */
class Test extends Command
{
    protected function configure()
    {
        $this->setName('test');
        $this->setDescription('Run the PHPUnit test suite');
        $this->setHelp('This command is a shorthand to run the PHPUnit binary. Does not support arguments.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>> phpunit</info>");

        return (new TextUICommand)->run([]);
    }
}
