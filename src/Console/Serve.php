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
        
        $this->addArgument('port', InputArgument::OPTIONAL, 'Listening port of the server');
        $this->addArgument('location', InputArgument::OPTIONAL, 'File or folder to match the server root folder');
        $this->addArgument('address', InputArgument::OPTIONAL, 'Listening address of the server');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $port = $input->getArgument('port') ?: '8000';
        $address = $input->getArgument('address') ?: 'localhost';
        $location = $input->getArgument('location') ? '-t ' . $input->getArgument('location') : '';
        $command = "php -S $address:$port $location";

        $output->writeln("<info>> $command</info>");
        
        system($command);

        return Command::SUCCESS;
    }
}
