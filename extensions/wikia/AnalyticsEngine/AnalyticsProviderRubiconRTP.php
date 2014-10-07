<?php

class AnalyticsProviderRubiconRTP implements iAnalyticsProvider {

	const OZ_SITE = '7450/11979';
	const OZ_ZONE = '145168';


	public static function isEnabled() {
		global $wgEnableAdEngineExt, $wgShowAds, $wgAdDriverUseSevenOneMedia;

		return $wgEnableAdEngineExt
			&& $wgShowAds
			&& AdEngine2Service::areAdsShowableOnPage()
			&& !$wgAdDriverUseSevenOneMedia;
	}

	public function getSetupHtml($params = array()) {
		global $wgAdDriverRubiconCachedOnly;

		static $called = false;
		$code = '';

		$ozSite = json_encode(self::OZ_SITE);
		$ozZone = json_encode(self::OZ_ZONE);
		$ozSlotSize = json_encode('300x250');
		$ozCachedOnly = json_encode((bool)$wgAdDriverRubiconCachedOnly);

		if (!$called && self::isEnabled()) {
			$code = <<< SCRIPT
<script>
	// Configuration through globals:
	oz_async = true;
	oz_cached_only = {$ozCachedOnly};
	oz_api = "valuation";
	oz_ad_server = "dart";
	oz_site = {$ozSite};
	oz_zone = {$ozZone};
	oz_ad_slot_size = {$ozSlotSize};

	require(['wikia.geo', 'wikia.instantGlobals', 'ext.wikia.adEngine.rubiconRtp'], function (geo, instantGlobals, rtp) {
		var rtpCountries = {
			US: 1,
			UK: 1,
			GB: 1,
			DE: 1,
			CA: 1,
			AU: 1,
			NZ: 1
		}, country = geo.getCountryCode();

		if (rtpCountries[country] && !instantGlobals.wgSitewideDisableRubiconRTP) {
			rtp.call();
		}
	});
</script>
SCRIPT;
		}

		$called = true;

		return $code;
	}

	public function trackEvent($event, $eventDetails = array()) {
		return '';
	}
}
