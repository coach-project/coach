<?php

namespace Coach\Scm;

interface ScmInterface {
	
	public function cloneRepository();
	public function checkout();

}