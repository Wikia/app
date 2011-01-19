<?php
class TestHookHandler extends WikiaHookHandler {
	public static $instancesCounter = 0;
	
	public function __construct() {
		self::$instancesCounter++;
	}
	
	public function onEvent() {
	}
}