<?php

namespace Coach\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Illuminate\Filesystem\Filesystem;

class LicenseCommand extends Command
{
    protected function configure() {
        $this
            ->setName('license')
            ->setDescription('Prints License')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
    	$filesystem = new Filesystem;
        $output->writeln($filesystem->get('LICENSE'));

    }
}
