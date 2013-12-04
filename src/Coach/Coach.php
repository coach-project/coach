<?php

namespace Coach;

use Illuminate\Filesystem\Filesystem;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Coach\Scm\Scm;
use Coach\Scm\Git\Git;
use Net;

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
		date_default_timezone_set("UTC");
		$ssh = new \Net_SSH2($this->config['targets'][0]['address']);
		
		if (!$ssh->login($this->config['targets'][0]['username'], $this->config['targets'][0]['password'])) { //if you can't log on...
			$this->output->writeln('Login Failed');
		}
		
		$this->output->writeln($ssh->getLog());
		$this->output->writeln($ssh->exec("ls"));
		
	}
	
}