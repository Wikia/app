<?php

if (empty($wgDevelEnvironment)) {
	error_log('File marked for deletion, but still used: ' . __FILE__);
} else {
	die('File marked for deletion, but still used: ' . __FILE__);
}

class AdProviderGamePro extends AdProviderAdEngine2 implements iAdProvider {
	public $name = 'GamePro';

	public static function getInstance() {
		if (self::$instance == false) {
			self::$instance = new AdProviderGamePro();
		}
		return self::$instance;
	}
}
