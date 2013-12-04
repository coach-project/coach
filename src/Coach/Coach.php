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
use Crypt;
use Illuminate;

/* set default timezone to utc */
date_default_timezone_set("UTC");

class Coach {
	
	private $config;
	private $output;
	private $ssh;
	
	public function __construct(OutputInterface $output) {
		$this->output = $output;
		if($this->output->isVerbose()) {
			$this->output->writeln("<info>Initializing Coach</info>");
		}
		
	}
	
	/* load configuration adn set up all variables etc. like server settings, git repos etc */
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
		$ssh = new \Net_SSH2($this->config['nodes'][0]['address']);
		$key = new \Crypt_RSA();
		$fs = new Filesystem();
		$key->loadKey($fs->get($this->config['nodes'][0]['key']));
		$this->output->writeln($ssh->getLog());
		
		if (!$ssh->login($this->config['nodes'][0]['username'], $key)) { //if you can't log on...
			$this->output->writeln('Login Failed');
		}
		
		$this->output->writeln($ssh->getLog());
		$this->output->writeln("inside Server");
		
		$this->output->writeln($ssh->exec("ls -al"));
		$this->output->writeln($ssh->getLog());
		
	}
	
}