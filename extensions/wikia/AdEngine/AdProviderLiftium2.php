<?php

class AdProviderLiftium2 extends AdProviderAdEngine2 implements iAdProvider {
	public $name = 'Liftium2';

	public static function getInstance() {
		if (self::$instance == false) {
			self::$instance = new AdProviderLiftium2();
		}
		return self::$instance;
	}
}