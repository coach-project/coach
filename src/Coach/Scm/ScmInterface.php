<?php

namespace Coach\Scm;

interface ScmInterface {
	
	public function getSlug();
	public function isBinaryAvailable();
	public function cloneRepository();
	public function checkout();

}