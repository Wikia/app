<?php

class AnalyticsProviderAmazonMatch implements iAnalyticsProvider {

	public static function isEnabled() {
		global $wgEnableAmazonMatch, $wgEnableAdEngineExt, $wgShowAds, $wgAdDriverUseSevenOneMedia;

		return $wgEnableAmazonMatch
			&& $wgEnableAdEngineExt
			&& $wgShowAds
			&& AdEngine2Service::areAdsShowableOnPage()
			&& !$wgAdDriverUseSevenOneMedia;
	}

	public function getSetupHtml($params = array()) {
		static $called = false;
		$code = '';

		if (!$called && self::isEnabled()) {
			$code = <<< SCRIPT
		<script>
			require(['ext.wikia.adEngine.amazonMatch', 'wikia.geo', 'wikia.instantGlobals'], function (amazonMatch, geo, globals) {
				if (globals.wgAmazonMatchCountries && globals.wgAmazonMatchCountries.indexOf(geo.getCountryCode()) > -1) {
					amazonMatch.call();
				}
			});
		</script>
SCRIPT;


		}

		return $code;
	}

	public function trackEvent($event, $eventDetails = array()) {
		return '';
	}
}
