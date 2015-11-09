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
		static $called = false;
		$code = '';

		$rtpConfig = json_encode(self::getRtpConfig());
		$rtpCountries = json_encode(self::getRtpCountries());

		if (!$called && self::isEnabled()) {
			$code = <<< SCRIPT
<script id="analytics-provider-rubicon-rtp">
	(function () {
		var geo = require('wikia.geo'),
			globals = require('wikia.instantGlobals'),
			rtp1,
			rtp2,
			rtp,
			rtpCountries = {$rtpCountries};

			try {
				// new name
				rtp1 = require('ext.wikia.adEngine.lookup.rubiconRtp');
			} catch (exception) {
				rtp1 = null;
			}

			try {
				// old name
				rtp2 = require('ext.wikia.adEngine.rubiconRtp');
			} catch (exception) {
				rtp2 = null;
			}

		if (geo.isProperGeo(rtpCountries) && !instantGlobals.wgSitewideDisableRubiconRTP) {
			rtp = rtp1 || rtp2;
			rtp.call({$rtpConfig});
		}
	})();
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
