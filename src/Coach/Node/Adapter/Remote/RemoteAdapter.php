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
	
	function __construct($config) {
		foreach($config as $k => $v) {
			$this->$k = $v;
		}
	}
	
	public function setLogger(Logger $logger) {
		$this->logger = $logger;
	}
	
	public function setRepo(ScmInterface $repo) {
		$this->repo = $repo;
	}
	
	public function executeCommand($command) {
		$this->shell->exec($command);
		return $this->shell->getLog();
	}
	public function deploy () {
		
		$this->setUpShell();
		
		/* check for scm */
		
		if($this->shell->exec($this->repo->isAvailable()) == "") {
			$this->logger->addCritical("No SCM found on the node. Please make sure scm is available");
			return;
		}
		
		$this->logger->addInfo("Deploying Git", array( $this->identifier ));
		//$this->logger->addInfo("whoami" . $this->executeCommand("whoami"), array( $this->identifier ));
		$this->logger->addInfo($this->executeCommand($this->repo->cloneRepository($this->target)), array( $this->identifier ));
		$this->shell->exec($this->repo->cloneRepository($this->target));
		
	}
	
	private function setUpShell() {
		$ssh = new \Net_SSH2($this->credentials['address']);
		$key = new \Crypt_RSA();
		$fs = new Filesystem();
		//$key->loadKey($fs->get($this->key));
		
		if (!$ssh->login($this->credentials['username'], $this->credentials['password'])) {
			throw CoachException("Cant Login");
		}
		
		$ssh->disableQuietMode();
		$this->shell = $ssh;
	}
}