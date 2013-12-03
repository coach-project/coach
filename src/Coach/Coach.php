<?php

namespace Coach;

use Illuminate\Filesystem\Filesystem;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;

class Coach {
	
	private $config;
	private $output;
	
	public function __construct(OutputInterface $output) {
		$this->output = $output;
		if($this->output->isVerbose()) {
			$this->output->writeln("<info>Initializing Coach</info>");
		}
		
	}
	
	private function prepareSystem() {
		
		if($this->output->isVerbose()) {
			$this->output->writeln("<info>Preparing System</info>");
		}
		
		/* get config file */
		$fs = new Filesystem;
		$this->config = json_decode($fs->get('.coach.json'), true);
		
		if($this->output->isVerbose()) {
			$this->output->writeln("<info>Finished Preparing System</info>");
		}
	}
	
	public function getVersion() {
		$fs = new Filesystem;
    	return $fs->get('VERSION');
	}
	
	public function getLicense() {
		$fs = new Filesystem;
		return $fs->get('LICENSE');
	}

	public function install() {
		$this->prepareSystem();
	}
	
}