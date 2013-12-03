<?php

namespace Coach\Scm\Git;

class Git extends ScmAbstract {

	public function cloneRepository($url) {
		return "git clone " . $url;
	}

	public function checkout($branch) {
		return "git checkout " . $branch;
	}

}
