<?php

class AnalyticsProviderAmazonDirectTargetedBuy implements iAnalyticsProvider {

	private static $code = <<< SCRIPT
		<script>
			require(['wikia.geo'], function (geo) {
				if (geo.getCountryCode() in %%COUNTRIES%%) {
					var aax_src='3006',
						aax_url = encodeURIComponent(document.location),
						s = document.createElement('script'),
						insertLoc = document.getElementsByTagName('script')[0];

					try { aax_url = encodeURIComponent("" + window.top.location); } catch(e) {}

					s.type = 'text/javascript';
					s.async = true;
					s.src = '//aax.amazon-adsystem.com/e/dtb/bid?src=' + aax_src + '&u=' + aax_url + "&cb=" + Math.round(Math.random()*10000000);

					insertLoc.parentNode.insertBefore(s, insertLoc);
				}
			});
		</script>
SCRIPT;

	public static function isEnabled() {
		global $wgEnableAmazonDirectTargetedBuy, $wgEnableAdEngineExt, $wgShowAds, $wgAdDriverUseSevenOneMedia;

		return $wgEnableAmazonDirectTargetedBuy
			&& $wgEnableAdEngineExt
			&& $wgShowAds
			&& AdEngine2Service::areAdsShowableOnPage()
			&& !$wgAdDriverUseSevenOneMedia;
	}

	public function getSetupHtml($params = array()) {
		global $wgAmazonDirectTargetedBuyCountriesDefault, $wgCityId;

		static $called = false;
		$code = '';

		if (!$called && self::isEnabled()) {
			$called = true;
			$countriesJS = [];

			$amazonCountries = WikiFactory::getVarValueByName(
				'wgAmazonDirectTargetedBuyCountries',
				[$wgCityId, Wikia::COMMUNITY_WIKI_ID],
				false,
				$wgAmazonDirectTargetedBuyCountriesDefault
			);

			if (is_array($amazonCountries)) {
				foreach ($amazonCountries as $countryCode) {
					if (is_string($countryCode)) {
						$countriesJS[$countryCode] = true;
					}
				}
			}

			if ($countriesJS) {
				$code = str_replace('%%COUNTRIES%%', json_encode($countriesJS), self::$code);
			}
		}

		return $code;
	}

	public function trackEvent($event, $eventDetails = array()) {
		return '';
	}
}
