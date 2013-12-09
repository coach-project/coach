<?php

namespace Coach\Scm;

use Coach\Scm\Adapter\Git\GitAdapter;
class Scm implements ScmInterface {
	
	private $adapter;
	
	function __construct($config) {
		if($config['type'] == 'git') {
			$this->setAdapter(new GitAdapter($config));
		}
	}
	
	public function isBinaryAvailable() {
		return $this->adapter->isBinaryAvailable();
	}
	
	public function setAdapter(ScmInterface $adapter) {
		$this->adapter = $adapter;
	}
	
	public function cloneRepository($path = null) {
		return $this->adapter->cloneRepository($path);
	}
	
	public function checkout() {
		return $this->adapter->checkout();
	}
	
}