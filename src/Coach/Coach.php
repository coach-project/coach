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
use Coach\Node\Node;
use Coach\Config\Config;

/* set default timezone to utc */
date_default_timezone_set("UTC");

class Coach {
	
	private $config, $output, $nodes, $logger;

	public function __construct(OutputInterface $output) {
		$this->output = $output;
		$this->nodes = array();
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
		
		$this->prepareCoach();
		$this->deploy();
	}

	/* load configuration and set up all variables etc. like server settings, git repos etc */
	private function prepareCoach() {
	
		$this->setUpLoggers();
		$this->logger->addInfo("Preparing Coach");
		$this->setUpConfig();
		$this->setUpNodes();
		$this->logger->addInfo("Finished Preparing System");
		
	}
	
	private function setUpLoggers() {
		
		/* set up logger */
		$this->logger = new Logger('Coach');
		$this->logger->pushHandler(new StreamHandler('coach.log'), Logger::DEBUG);
		$this->logger->pushHandler(new ConsoleHandler($this->output));
		
		$this->logger->addDebug("Initialized Loggers");
		
	}
	
	private function setUpConfig() {

		$this->logger->addDebug("Configuring Coach");
		
		/* get config file */
		$fs = new Filesystem;
		try {
			$this->config = new Config($fs->get('.coach.json'));
		} catch (FileNotFoundException $e) {
			$this->logger->addCritical($e->getMessage());
			throw new CoachException("Coach Failed. Please refer to logs for more details.");
		}
		
		$this->logger->addDebug("Handing Logger over to Config");
		
		$this->config->set('logger', $this->logger);
		
		$this->logger->addDebug("Configured Coach Successfully");

	}
	
	private function setUpNodes() {

		foreach($this->config->get('nodes') as $node) {

			$node['identifier'] = "node" . (count($this->nodes) + 1); 
			$new_node = new Node($node);
			
			$new_node->setLogger($this->logger);
			$new_node->setRepo(new Scm($this->config->get('repository')));
			
			$this->nodes[] = $new_node;
			
		}
		
	}
	
	private function deploy() {
		foreach($this->nodes as $key => $node) {
			$node->deploy();
		}
	}
	
}


/*

$scm = new Scm($this->config['repository']);
$this->output->writeln($scm->cloneRepository());
 
*/



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
