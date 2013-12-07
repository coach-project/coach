<?php

namespace Coach\Node;

use Coach\Node\Adapter\Remote\Remote;

class Node implements NodeInterface {
	
	private $adapter;
	
	function __construct($config) {
		if($config['type'] == "remote") {
			$this->setAdapter(new Remote($config));
		}
	}
	
	public function setAdapter(NodeInterface $adapter) {
		$this->adapter = $adapter;
	}
	
	public function executeCommand($command) {
		return $this->adapter->executeCommand($command);
	}
	
	public function setLogger($logger) {
		$this->adapter->setLogger($logger);
	}
}