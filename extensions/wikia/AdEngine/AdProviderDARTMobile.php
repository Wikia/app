<?php
require_once dirname(__FILE__) . '/AdProviderDART.php';

class AdProviderDARTMobile extends AdProviderDART {
	public function getAd($slotname, $slot, $params = null){
		wfProfileIn(__METHOD__);

		$slot['size']='5x5'; // Odd convention for mobile

		$out = "<!-- " . __CLASS__ . " slot: $slotname -->";

		//this JS code uses addEventListener, which is supported starting from IE 9
		//on mobile devices, that is the least you can get on WP7, no need to fallback
		//to attachEvent :)
		//Also, the code is compacted manually to be as small as possible while being
		//readable and maintainable.
		$out .= <<<JSCODE
<script>window.addEventListener('load', function () {
	require(['ads'], function (ads) { ads.setupSlot('{$slotname}', '{$slot['size']}', 'DARTMobile'); });
});</script>
JSCODE;

		wfProfileOut(__METHOD__);
		return $out;
	}

	public static function getInstance() {
			if ( self::$instance == false ) {
				self::$instance = new AdProviderDARTMobile();
			}

			return self::$instance;
	}
}