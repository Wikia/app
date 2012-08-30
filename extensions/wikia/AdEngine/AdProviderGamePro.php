<?php

class AdProviderGamePro extends AdProviderAdEngine2 implements iAdProvider {
	public $name = 'GamePro';

	public static function getInstance() {
		if (self::$instance == false) {
			self::$instance = new AdProviderGamePro();
		}
		return self::$instance;
	}
}