<?php

namespace Coach\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Illuminate\Filesystem\Filesystem;

use Coach\Scm;

class InstallCommand extends Command
{
    protected function configure() {
        $this
            ->setName('install')
            ->setDescription('Installs project using coach')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
    	
    	/* get config file */
        $fs = new Filesystem;
        $config = json_decode($fs->get('.coach.json'), true);

        $git = new Git;
        $git->cloneRepository($config['repository']['url'], $config['repository']['branch'], $config['install-dir']);
    }
}
