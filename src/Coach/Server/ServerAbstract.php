<?php

abstract class ServerAbstract {
	private $address;
	private $type;
	private $credentials;
	
	function __construct() {
		
	}
	
	function getAddress() {
		return $this->address;
	}
}