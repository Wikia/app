<?php
class TestHookHandler {
	public static $instancesCounter = 0;
	
	public function __construct() {
		self::$instancesCounter++;
	}
	
	public function onEvent() {
		// Do nothing hook
	}
}