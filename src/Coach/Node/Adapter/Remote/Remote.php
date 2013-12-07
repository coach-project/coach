<?php

namespace Coach\Node\Adapter\Remote;

use Coach\Node\NodeInterface;
use Coach\Exception\CoachException;
use Illuminate\Filesystem\Filesystem;

class Remote implements NodeInterface {
	
	private $address;
	private $port;
	private $key;
	private $username;
	private $password;
	private $logger;
	
	private $shell;
	
	function __construct($config) {
		foreach($config as $k => $v) {
			$this->$k = $v;
		}
		
		$this->setUpShell();
	}
	
	public function setLogger($logger) {
		$this->logger = $logger;
	}
	
	public function executeCommand($command) {
		$this->shell->exec($command);
	}
	
	private function setUpShell() {
		$ssh = new \Net_SSH2($this->address);
		$key = new \Crypt_RSA();
		$fs = new Filesystem();
		$key->loadKey($fs->get($this->key));
		
		
		if (!$ssh->login($this->username, $key)) { //if you can't log on...
			throw CoachException("Cant Login");
		}
		
		$this->shell = $ssh;
		
		//$this->logger->addInfo("Logged In");
	}
}