<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'AdEngine',
	'author' => 'Inez Korczynski, Nick Sullivan'
);

interface iAdProvider {
	public static function getInstance();
	public function getAd($slotname, $slot);
}

class AdEngine {

	const cacheKeyVersion = "1.5";

	const cacheTimeout = 1800;

	// TODO: pull these from wikicities.provider
	private $providers = array('1' => 'DART', '2' => 'OpenX', '3' => 'Google', '-1' => 'Null');

	private $slots = array();

	protected static $instance = false;

	protected function __construct() {
		$this->loadConfig();
		global $wgAutoloadClasses;
		foreach($this->providers as $p) {
			$wgAutoloadClasses['AdProvider' . $p]=dirname(__FILE__) . '/AdProvider'.$p.'.php';
		}
	}

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdEngine();
		}
		return self::$instance;
	}

	public function loadConfig() {
		$skin_name = 'monaco'; // Hard code for now.
		global $wgMemc, $wgCityId;

		$cacheKey = wfMemcKey('slots', $skin_name, self::cacheKeyVersion);
		$this->slots = $wgMemc->get($cacheKey);

		if(is_array($this->slots)){
			// Found a cached value
			return true;
		}
			
		$db = wfGetDB(DB_SLAVE);

		$sql = "SELECT ad_slot.as_id, ad_slot.slot, ad_slot.size,
				COALESCE(adso.provider_id, ad_slot.default_provider_id) AS provider_id,
				COALESCE(adso.enabled, ad_slot.default_enabled) AS enabled
				FROM wikicities.ad_slot
				LEFT OUTER JOIN wikicities.ad_slot_override AS adso
				  ON ad_slot.as_id = adso.as_id AND city_id=".intval($wgCityId)."
				WHERE skin='".$db->strencode($skin_name)."'";

		$res = $db->query($sql);

		while($row = $db->fetchObject($res)){
			$this->slots[$row->slot] = array(
				'as_id' => $row->as_id,
				'size' => $row->size,
				'provider_id' => $row->provider_id,
				'enabled' => $row->enabled
			);
		}

		$sql = "SELECT * FROM wikicities.ad_provider_value WHERE
			 (city_id = ".intval($wgCityId)." OR city_id IS NULL) ORDER by city_id";
		$res = $db->query($sql);
		while($row = $db->fetchObject($res)) {
			 foreach($this->slots as $slotname => $slot) {
			 	if($slot['provider_id'] == $row->provider_id){
					$this->slots[$slotname]['provider_values'][$row->keyname] = $row->keyvalue;
			 	}
			 }
		}
		$wgMemc->set($cacheKey, $this->slots, self::cacheTimeout);

		return true;
	}

	public function getAd($slotname) {
		if(!empty($this->providers[$this->slots[$slotname]['provider_id']])) {
			$provider = $this->getAdProvider($this->slots[$slotname]['provider_id']);
			return $provider->getAd($slotname, $this->slots[$slotname]);
		} else {
			// Note: Don't throw an exception here. Fail gracefully for ads,
			// don't under any circumstances fail the rendering of the page
			return "<!-- Bad Ad Call -->";
		}
	}

	private function getAdProvider($provider_id) {
		if($this->providers[$provider_id] == 'DART') {
			return AdProviderDART::getInstance();
		} else if($this->providers[$provider_id] == 'OpenX') {
			return AdProviderOpenX::getInstance();
		} else {
			// Note: Don't throw an exception here. Fail gracefully for ads,
			// don't under any circumstances fail the rendering of the page
			return AdProviderNull::getInstance();
		}
	}
}
