<?php

namespace Coach\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Illuminate\Filesystem\Filesystem;

class VersionCommand extends Command
{
    protected function configure() {
        $this
            ->setName('version')
            ->setDescription('Prints Coach\'s version')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
    	$filesystem = new Filesystem;
        $output->writeln($filesystem->get('VERSION'));

    }
}
