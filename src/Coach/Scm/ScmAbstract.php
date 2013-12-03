<?php

namespace Coach\Scm;

abstract class ScmAbstract {
	
	public function check();
	
	public function checkout($branch);
	
}