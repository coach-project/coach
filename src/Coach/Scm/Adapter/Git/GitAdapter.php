<?php

namespace Coach\Scm\Adapter\Git;

use Coach\Scm\ScmInterface;

class GitAdapter implements ScmInterface {
	
	private $binary;
	private $url;
	private $branch;
	
	function __construct($config) {
		$this->binary = 'git';
		$this->url = $config['url'];
		$this->branch = $config['branch'];
	}
	
	public function cloneRepository() {
		return $this->binary . ' clone ' . $this->url;
	}
	
	public function checkout() {
		return $this->binary . ' checkout ' . $this->branch;
	}
}