<?php

namespace Coach\Node\Adapter\Local;

use Coach\Node\NodeInterface;
use Coach\Exception\CoachException;
use Illuminate\Filesystem\Filesystem;
use Coach\Scm\ScmInterface;
use Monolog\Logger;

class LocalAdapter implements NodeInterface {
	
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
	}
	
	public function setLogger(Logger $logger) {
		$this->logger = $logger;
	}
	
	public function setRepo(ScmInterface $repo) {
		$this->repo = $repo;
	}
	
	public function executeCommand($command) {
		$this->exec($command);
	}
	
	private function setUpShell() {
		/* nothing to do here right now */
	}
}