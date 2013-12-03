<?php

namespace Coach\Scm;

interface ScmInterface {
	
	public function check();
	
	public function checkout($branch);
	
}