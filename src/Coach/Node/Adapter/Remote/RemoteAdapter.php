<?php

namespace Coach\Node\Adapter\Remote;

use Coach\Node\NodeInterface;
use Coach\Exception\CoachException;
use Illuminate\Filesystem\Filesystem;
use Coach\Scm\ScmInterface;
use Monolog\Logger;

class RemoteAdapter implements NodeInterface {
	
	private $credentials;
	private $logger;
	private $repo;
	
	private $shell;
	
	private $canDeplay;
	
	function __construct($config) {

		foreach($config as $k => $v) {
			$this->$k = $v;
		}
		
		$this->canDeploy = false;
		
	}
	
	public function setLogger(Logger $logger) {
		$this->logger = $logger;
	}
	
	public function setRepo(ScmInterface $repo) {
		$this->repo = $repo;
	}
	
	public function executeCommand($command) {
		return $this->shell->exec($command);
	}
	public function deploy () {
		
		$this->setUpShell();
		
		/* check for scm */
		$this->logger->addInfo("Running as " . trim($this->executeCommand("whoami") , '\n\r'), array( $this->identifier ));
		if($this->executeCommand(($this->repo->isAvailable()) == "")) {
			$this->logger->addCritical("No SCM found on the node. Please make sure scm is available");
			return;
		}
		
		/*$this->logger->addInfo("Deploying Git", array( $this->identifier ));
		$this->logger->addInfo("whoami" . $this->executeCommand("whoami"), array( $this->identifier ));
		$this->logger->addInfo($this->executeCommand($this->repo->cloneRepository($this->target)), array( $this->identifier ));*/
		
		
	}
	
	private function setUpShell() {
		
		$ssh = new \Net_SSH2($this->credentials['address']);
		
		if(isset($this->credentials['key'])) {
			$key = new \Crypt_RSA();
			$fs = new Filesystem();
			$key->loadKey($fs->get($this->key));
			if (!$ssh->login($this->credentials['username'], $key)) {
				$this->logger->addCritical("Cannot login.", array($this->identifier));
				$this->canDeplay = false;
				return;
			}	
		} elseif(isset($this->credentials['password'])) {
			if (!$ssh->login($this->credentials['username'], $this->credentials['password'])) {
				$this->logger->addCritical("Cannot login.", array($this->identifier));
				$this->canDeplay = false;
				return;
			}
		} else {
			$this->logger->addCritical("Credentials not found.", array($this->identifier));
		}
		
		$ssh->disableQuietMode();
		$this->shell = $ssh;
	}
}