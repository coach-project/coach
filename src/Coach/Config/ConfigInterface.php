<?php

namespace Coach\Config;

interface ConfigInterface {

	public function get($key);
	public function set($key, $value);

}