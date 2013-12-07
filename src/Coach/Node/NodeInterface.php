<?php

namespace Coach\Node;

use Monolog\Logger;
use Coach\Scm\ScmInterface;
interface NodeInterface {
	
	public function executeCommand($command);
	public function setLogger(Logger $logger);
	public function setRepo(ScmInterface $repo);
	
}