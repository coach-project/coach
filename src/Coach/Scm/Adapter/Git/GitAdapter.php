<?php

namespace Coach\Scm\Adapter\Git;

use Coach\Scm\ScmInterface;

class GitAdapter implements ScmInterface {
	
	private $binary;
	private $url;
	private $branch;
	private $slug;
	
	function __construct($config) {
		$this->binary = 'git';
		$this->url = $config['url'];
		$this->branch = $config['branch'];
		$this->slug = $config['slug'];
	}
		
	public function isBinaryAvailable() {
		return "which " . $this->binary;
	}
	
	public function getSlug() {
		return $this->slug;
	}
	
	public function cloneRepository( $path = null) {
		return $this->binary . ' clone ' . $this->url . ((!is_null($path)) ? " " . $path : "");
	}
	
	public function checkout() {
		return $this->binary . ' checkout ' . $this->branch;
	}
}