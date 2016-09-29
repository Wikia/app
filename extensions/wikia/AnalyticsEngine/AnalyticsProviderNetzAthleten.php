<?php

class AnalyticsProviderNetzAthleten implements iAnalyticsProvider {

	public static function isEnabled() {
		//TODO: add $wgVar
		return AdEngine2Service::areAdsShowableOnPage();
	}

	private static function getIntegrationScript() {
		//TODO: add pege level targeting
		$code = <<< CODE
<script type="text/javascript" src="//s.adadapter.netzathleten-media.de/API-1.0/NA-828433-1/naMediaAd.js"></script>
<script type="text/javascript">
  naMediaAd.setValue("homesite", false); 
</script>	
	
CODE;

		return $code;
	}

	public function getSetupHtml( $params = array() ) {
		static $called = false;

		if ( $called ) {
			return '';
		}

		$called = true;

		if ( !static::isEnabled() ) {
			return '';
		}
		
		return static::getIntegrationScript();
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}
