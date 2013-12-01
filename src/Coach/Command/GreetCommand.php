<?php

namespace Coach\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GreetCommand extends Command
{
    protected function configure() {
        $this
            ->setName('greet')
            ->setDescription('Greetings from Coach')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln('Good Day!');
    }
}
