<?php

namespace Coach\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Coach\Coach;


class LicenseCommand extends Command
{
    protected function configure() {
        $this
            ->setName('license')
            ->setDescription('Prints License')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
    	
    	$coach = new Coach($output);
    	$output->writeln($coach->getLicense());

    }
}
