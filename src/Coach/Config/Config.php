<?php

namespace Coach\Config;

use Seld\JsonLint\JsonParser;
class Config implements ConfigInterface {
	
	private $settings;
	private $parser;
	
	private $logger;
	

	function __construct($config, $logger) {
		$this->settings = array();
		$this->parser = new JsonParser();
		$this->logger = $logger;
		$this->parse($config);
	}
	
	public function get($key) {
		return $this->settings[$key];
	}
	
	public function set($key, $value) {
		$this->settings[$key] = $value;
	}
	
	private function parse($config) {
		
		$this->parser->parse($config);
		
		foreach(json_decode($config, true) as $key => $value) {
			$this->settings[$key] = $value;
		}
				
	}
	
}