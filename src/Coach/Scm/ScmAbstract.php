<?php

namespace Coach\Scm;

abstract ScmAbstract {
	
	public function check();
	
	public function checkout($branch);
	
}