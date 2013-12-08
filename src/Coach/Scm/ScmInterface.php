<?php

namespace Coach\Scm;

interface ScmInterface {
	
	public function isAvailable();
	public function cloneRepository();
	public function checkout();

}