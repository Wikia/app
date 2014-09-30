<?php

class AnalyticsProviderRubiconRTP implements iAnalyticsProvider {

	const RTP_CONFIG = 'wgAdDriverRubiconRTPConfig';
	const RTP_COUNTRIES = 'wgAdDriverRubiconRTPCountries';

	public static function getRtpConfig() {
		static $config;

		if ($config !== null) {
			return $config;
		}

		$globalConfig = WikiFactory::getVarValueByName(self::RTP_CONFIG, WikiFactory::COMMUNITY_CENTRAL);

		if ($globalConfig && is_array($globalConfig)) {
			foreach ($globalConfig as $rtpConfig) {

				if (isset($rtpConfig['disabled']) && $rtpConfig['disabled']) {
					continue;
				}
				if (isset($rtpConfig['skin']) && !F::app()->checkSkin($rtpConfig['skin'])) {
					continue;
				}
				return $config = $rtpConfig;
			}
		}

		return $config = false;
	}

	public static function getRtpCountries() {
		static $countries;

		if ($countries) {
			return $countries;
		}

		return $countries = WikiFactory::getVarValueByName(self::RTP_COUNTRIES, WikiFactory::COMMUNITY_CENTRAL);
	}


	public static function isEnabled() {
		global $wgEnableAdEngineExt, $wgShowAds, $wgAdDriverUseSevenOneMedia;

		return $wgEnableAdEngineExt
			&& $wgShowAds
			&& AdEngine2Service::areAdsShowableOnPage()
			&& self::getRtpCountries()
			&& self::getRtpConfig()
			&& !$wgAdDriverUseSevenOneMedia;
	}

	public function getSetupHtml($params = array()) {
		global $wgAdDriverRubiconCachedOnly;

		static $called = false;
		$code = '';

		$rtpConfig = json_encode(self::getRtpConfig());
		$rtpCountries = json_encode(self::getRtpCountries());

		$ozCachedOnly = json_encode((bool)$wgAdDriverRubiconCachedOnly);

		if (!$called && self::isEnabled()) {
			$code = <<< SCRIPT
<script>
	rp_config = {$rtpConfig};
	// Configuration through globals:
	oz_async = true;
	oz_cached_only = {$ozCachedOnly};
	oz_api = rp_config.oz_api || "valuation";
	oz_ad_server = rp_config.oz_ad_server || "dart";
	oz_site = rp_config.oz_site;
	oz_zone = rp_config.oz_zone;
	oz_ad_slot_size = rp_config.oz_ad_slot_size;

	require(['wikia.geo', 'wikia.instantGlobals', 'ext.wikia.adEngine.rubiconRtp'], function (geo, instantGlobals, rtp) {
		var rtpCountries = {$rtpCountries}, country = geo.getCountryCode();

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
