<?php

if (empty($wgDevelEnvironment)) {
	error_log('File marked for deletion, but still used: ' . __FILE__);
} else {
	die('File marked for deletion, but still used: ' . __FILE__);
}

class AdProviderLiftium2 extends AdProviderAdEngine2 implements iAdProvider {
	public $name = 'Liftium2';

	public static function getInstance() {
		if (self::$instance == false) {
			self::$instance = new AdProviderLiftium2();
		}
		return self::$instance;
	}
}
