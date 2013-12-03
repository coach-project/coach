<?php

namespace Coach;

use Illuminate\Filesystem\Filesystem;

class Coach {
	
	public function __constrcut() {
		
	}
	
	public function getVersion() {
		$fs = new Filesystem;
    	return $fs->get('VERSION');
	}
	
	public function getLicense() {
		$fs = new Filesystem;
		return $fs->get('LICENSE');
	}

	public function install() {
		
	}
	
}