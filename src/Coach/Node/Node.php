<?php

namespace Coach\Node;

use Coach\Node\Adapter\Remote\RemoteAdapter;
use Monolog\Logger;
use Coach\Scm\ScmInterface;
use Coach\Node\Adapter\Local\LocalAdapter;

class Node implements NodeInterface {
	
	private $adapter;
	
	function __construct($config) {
		if($config['type'] == "remote") {
			$this->setAdapter(new RemoteAdapter($config));
		} elseif($config['type'] == "local") {
			$this->setAdapter(new LocalAdapter($config));
		}
	}
	
	public function setAdapter(NodeInterface $adapter) {
		$this->adapter = $adapter;
	}
	
	public function executeCommand($command) {
		return $this->adapter->executeCommand($command);
	}
	
	public function setLogger(Logger $logger) {
		$this->adapter->setLogger($logger);
	}
	
	public function setRepo(ScmInterface $repo) {
		$this->adapter->setRepo($repo);
	}
	
	public function deploy () {
		$this->adapter->deploy();
	}
	
	public function prepare() {
		$this->adapter->prepare();
	}
	
	public function canDeploy() {
		$this->adapter->canDeploy();
	}
	
	public function getIdentifier() {
		$this->adapter->getIdentifier();
	}
}