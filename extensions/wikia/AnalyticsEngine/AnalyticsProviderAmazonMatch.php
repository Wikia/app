<?php

class AnalyticsProviderAmazonMatch implements iAnalyticsProvider {

	public static function isEnabled() {
		global $wgEnableAmazonMatch, $wgEnableAmazonMatchOld,
			$wgEnableAdEngineExt, $wgShowAds, $wgAdDriverUseSevenOneMedia;

		return ($wgEnableAmazonMatch || $wgEnableAmazonMatchOld)
			&& $wgEnableAdEngineExt
			&& $wgShowAds
			&& AdEngine2Service::areAdsShowableOnPage()
			&& !$wgAdDriverUseSevenOneMedia;
	}

	public function getSetupHtml($params = array()) {
		global $wgEnableAmazonMatch, $wgEnableAmazonMatchOld;

		static $called = false;

		$code = '';

		if (!$called && self::isEnabled()) {
			$oldEnabled = json_encode((bool) $wgEnableAmazonMatchOld);
			$newEnabled = json_encode((bool) $wgEnableAmazonMatch);

			$code = <<< SCRIPT
		<script id="analytics-provider-amazon-match">
			require([
				'ext.wikia.adEngine.amazonMatch',
				'ext.wikia.adEngine.amazonMatchOld',
				'wikia.geo',
				'wikia.instantGlobals'
			], function (amazonMatch, amazonMatchOld, geo, globals) {

				// Old integration:
				if ($oldEnabled // old integration enabled?
					&& globals.wgAmazonMatchOldCountries
					&& globals.wgAmazonMatchOldCountries.indexOf
					&& globals.wgAmazonMatchOldCountries.indexOf(geo.getCountryCode()) > -1
				) {
					amazonMatchOld.call();
				}

				// New integration:
				if ($newEnabled // new integration enabled?
					&& globals.wgAmazonMatchCountries
					&& globals.wgAmazonMatchCountries.indexOf
					&& globals.wgAmazonMatchCountries.indexOf(geo.getCountryCode()) > -1
				) {
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
