<?php

namespace Coach\Scm\Git;

use Coach\Scm\ScmInterface;

class Git implements ScmInterface {

	public function cloneRepository($url) {
		return "git clone " . $url;
	}

	public function checkout($branch) {
		return "git checkout " . $branch;
	}

}
