<?php

namespace Coach\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InstallCommand extends Command
{
    protected function configure() {
        $this
            ->setName('install')
            ->setDescription('Installs project using coach')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln('Good Day!');
    }
}
