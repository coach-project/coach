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
	private $canDeploy;
	private $identifier;
	
	private $username, $hostname;
	
	function __construct($config) {

		foreach($config as $k => $v) {
			$this->$k = $v;
		}
		
		$this->canDeploy = true;
		
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
	
	public function getIdentifier() {
		return $this->identifier;
	}
	
	public function canDeploy() {
		return $this->canDeploy;
	}
	
	public function prepare() {
		if(!$this->setUpShell()) {
			$this->logger->addCritical("Cant access node. Make sure the node is available. Please check logs for detials");
			return false;
		}

		$this->username = trim($this->executeCommand("whoami") , '\n\r
');
		$this->hostname = trim($this->executeCommand("hostname") , '\n\r
');
		$this->logger->addInfo("Running as " . $this->username . '@' . $this->hostname, array( $this->identifier ));

		if($this->executeCommand($this->repo->isBinaryAvailable()) == "") {
			$this->logger->addCritical("SCM binary not found! Please make sure scm is available", array( $this->identifier ));
			return false;
		}
	}
	
	public function deploy () {
		
		if($this->canDeploy === false) {
			$this->logger->addCritical("Can't Deploy on this node. Please refer to logs", array($this->identifier));
			return false;
		}
		
		$this->logger->addInfo("Deploying Git", array( $this->identifier ));
		
		/* check dir and create one if not exists */
		$this->logger->addInfo($this->executeCommand('pwd'));
		$this->logger->addInfo($this->executeCommand($this->repo->cloneRepository("~/coach/")), array( $this->identifier ));
		
		

	}
	
	private function setUpShell() {

		$ssh = new \Net_SSH2($this->credentials['address']);
		
		if(isset($this->credentials['key'])) {
			$key = new \Crypt_RSA();
			$fs = new Filesystem();
			$key->loadKey($fs->get($this->key));
			if (!$ssh->login($this->credentials['username'], $key)) {
				$this->logger->addCritical("Cannot login.", array($this->identifier));
				return false;
			}	
		} elseif(isset($this->credentials['password'])) {
			if (!$ssh->login($this->credentials['username'], $this->credentials['password'])) {
				$this->logger->addCritical("Cannot login.", array($this->identifier));
				return false;
			}
		} else {
			$this->logger->addCritical("Credentials not found.", array($this->identifier));
		}

		$ssh->disableQuietMode();
		$this->shell = $ssh;
		return true;
	}
	
}