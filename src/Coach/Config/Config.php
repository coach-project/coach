<?php

namespace Coach\Config;

class Config implements ConfigInterface {
	
	private $settings;

	function __construct($config) {
		$this->settings = array();
		
		foreach($config as $k => $v) {
			$this->settings[$k] = $v;
		}
	}
	
	public function get($key) {
		return $this->settings[$key];
	}
	
	public function set($key, $value) {
		$this->settings[$key] = $value;
	}
	
}