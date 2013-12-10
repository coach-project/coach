<?php

namespace Coach\Config;

use Seld\JsonLint\JsonParser;
class Config implements ConfigInterface {
	
	private $nodes;
	private $name;
	private $deployTo;
	private $repo;
	private $settings;
	private $parser;

	function __construct($config) {
		$this->settings = array();
		$this->repo = array();
		$this->nodes = array();
		$this->parser = new JsonParser();
		
		$this->parse($config);
	}
	
	public function get($key) {
		return $this->$key;
	}
	
	public function set($key, $value) {
		$this->$key = $value;
	}
	
	private function parse($config) {
		
		$this->parser->parse($config);
		
		foreach(json_decode($config, true) as $key => $value) {
			$this->$key = $value;
		}
				
	}
	
}