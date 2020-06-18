<?php

namespace Apio\Console;

use PHPUnit\TextUI\Command as TextUICommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PHPUnit extends Command
{
    protected function configure()
    {
        $this->setName('test');
        $this->setDescription('Run the PHPUnit test suite');
        $this->setHelp('This command is a shorthand for `./vendor/bin/phpunit`');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $args = $input->getArguments();
        unset($args['command']);

        return (new TextUICommand)->run($args);
    }
}
