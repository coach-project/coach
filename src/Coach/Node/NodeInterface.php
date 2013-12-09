<?php

namespace Coach\Node;

use Monolog\Logger;
use Coach\Scm\ScmInterface;
interface NodeInterface {
	
	public function getIdentifier();
	public function canDeploy();
	public function executeCommand($command);
	public function setLogger(Logger $logger);
	public function setRepo(ScmInterface $repo);
	public function prepare();
	public function deploy();
	
}