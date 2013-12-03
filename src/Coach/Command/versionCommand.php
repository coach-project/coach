<?php

namespace Coach\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Coach\Coach;

class VersionCommand extends Command
{
    protected function configure() {
        $this
            ->setName('version')
            ->setDescription('Prints Coach\'s version')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
    	
    	$coach = new Coach;
    	$output->writeln($coach->getVersion());

    }
}
