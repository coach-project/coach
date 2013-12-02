<?php

namespace Coach\Git;

class Git {

	public static function isGitinstalled() {
		$this->execute('which git', $output);
		$git = file_exists($line = trim(current($output))) ? $line : 'git';
		unset($output);
		$this->execute($git . ' --version', $output);
		preg_match('#^(git version)#', current($output), $matches);
		return ! empty($matches[0]) ? $git : false;
	}

	public function cloneRepository($url, $branch, $dir = null) {
		$cwd = getcwd();
		if(!is_null($dir)) {
			chdir($dir);
		}

		$this->execute('git clone ' . $url, $out, $rval);
		$this->execute('git checkout ' . $branch, $out, $rval);

		chdir($cwd);
	}

	private function execute($command, &$output, &$returnValue) {
        exec($command, $output, $returnValue);
    }
}
