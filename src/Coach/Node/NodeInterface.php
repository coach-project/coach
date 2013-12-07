<?php

namespace Coach\Node;

interface NodeInterface {
	
	public function executeCommand($command);
	public function setLogger($logger);
	
}