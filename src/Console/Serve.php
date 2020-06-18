<?php

namespace Apio\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Execs the php built-in server
 */
class Serve extends Command
{
    protected function configure()
    {
        $this->setName('serve');
        $this->setDescription('Launch the php built-in web server');
        $this->setHelp('Warning: This web server was designed to aid application development. It may also be useful for testing purposes or for application demonstrations that are run in controlled environments. It is not intended to be a full-featured web server. It should not be used on a public network.');
        $this->addArgument('address', InputArgument::OPTIONAL, 'Listening address of the server');
        $this->addArgument('location', InputArgument::OPTIONAL, 'File or folder to match the server root folder');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $address = $input->getArgument('address') ?: 'localhost:8000';
        $location = $input->getArgument('location');
        $location = ($location) ? `-t $location` : '';

        $command = "php -S $address $location";

        $output->writeln($command);
        system($command);

        return Command::SUCCESS;
    }
}
