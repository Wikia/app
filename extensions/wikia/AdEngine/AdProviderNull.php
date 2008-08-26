<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'Null ad provider for AdEngine'
);

class AdProviderNull implements iAdProvider {

	protected static $instance = false;

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdProviderNull();
		}
		return self::$instance;
	}

	public function getAd($slotname, $slot) {
                // TODO Log these?
		return "<!-- Null Ad: $slotname, " . print_r($slot, true) . "-->";

	}

}
