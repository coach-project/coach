<?php

namespace Coach;

use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Coach\Scm\Scm;
use Net;
use Crypt;
use Illuminate;
use Coach\Exception\CoachException;
use Illuminate\Filesystem\FileNotFoundException;
use Monolog\Logger;
use Symfony\Bridge\Monolog\Handler\ConsoleHandler;
use Monolog\Handler\StreamHandler;
use Coach\Scm\Adapter\Git\GitAdapter;

/* set default timezone to utc */
date_default_timezone_set("UTC");

class Coach {
	
	private $config;
	private $output;
	private $ssh;
	private $nodes;
	private $log;

	public function __construct(OutputInterface $output) {
		$this->output = $output;
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
		
		$scm = new Scm($this->config['repository']);
		
		$this->output->writeln($scm->cloneRepository());

		/*$ssh = new \Net_SSH2($this->config['nodes'][0]['address']);
		$key = new \Crypt_RSA();
		$fs = new Filesystem();
		$key->loadKey($fs->get($this->config['nodes'][0]['key']));
		$this->output->writeln($ssh->getLog());
		
		if (!$ssh->login($this->config['nodes'][0]['username'], $key)) { //if you can't log on...
			$this->output->writeln('<error>Login Failed</error>');
		}
		
		$this->output->writeln($ssh->getLog());
		
		$this->output->writeln($ssh->exec("cd " . $this->config["install-dir"]));
		$this->output->writeln($ssh->getLog());
				
		$this->output->writeln($ssh->exec("ls -al"));
		$this->output->writeln($ssh->getLog());*/
		
	}

	/* load configuration adn set up all variables etc. like server settings, git repos etc */
	private function prepareSystem() {
	
		$this->setUpLoggers();
	
		$this->log->addInfo("Preparing Coach");
		$this->setUpConfig();
		$this->log->addInfo("Finished Preparing System");
		
	}
	
	private function setUpLoggers() {
		
		/* set up logger */
		$this->log = new Logger('Coach');
		$this->log->pushHandler(new StreamHandler('coach.log'), Logger::DEBUG);
		$this->log->pushHandler(new ConsoleHandler($this->output));
		
		$this->log->addDebug("Initialized Loggers");
		
	}
	
	private function setUpConfig() {

		$this->log->addDebug("Configuring Coach");
		
		/* get config file */
		$fs = new Filesystem;
		try {
			$this->config = json_decode($fs->get('.coach.json'), true);
		} catch (FileNotFoundException $e) {
			$this->log->addCritical($e->getMessage());
			throw new CoachException("Coach Failed. Please refer to logs for more details.");
		}
		
		$this->servers = $this->config['nodes'];
		
		$this->log->addDebug("Configured Coach Successfully");

	}
	
}