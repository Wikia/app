<?php

class AnalyticsProviderAmazonDirectTargetedBuy implements iAnalyticsProvider {

	private static $code = <<< SCRIPT
		<script>
			require(['wikia.geo'], function (geo) {
				if (geo.getCountryCode() in %%COUNTRIES%%) {
					var aax_src='3006',
						aax_url = encodeURIComponent(document.location),
						host = (geo.getCountryCode() === 'US') ? 'aax-us-east' : 'aax',
						s = document.createElement('script'),
						insertLoc = document.getElementsByTagName('script')[0];

					try { aax_url = encodeURIComponent("" + window.top.location); } catch(e) {}

					s.type = 'text/javascript';
					s.async = true;
					s.src = '//' + host + '.amazon-adsystem.com/e/dtb/bid?src=' + aax_src + '&u=' + aax_url + "&cb=" + Math.round(Math.random()*10000000);

					insertLoc.parentNode.insertBefore(s, insertLoc);
				}
			});
		</script>
SCRIPT;

	public static function isEnabled() {
		global $wgEnableAmazonDirectTargetedBuy, $wgShowAds, $wgAdDriverUseSevenOneMedia;

		return $wgEnableAmazonDirectTargetedBuy
			&& $wgShowAds
			&& AdEngine2Controller::areAdsShowableOnPage()
			&& !$wgAdDriverUseSevenOneMedia;
	}

	public function getSetupHtml($params = array()) {
		global $wgAmazonDirectTargetedBuyCountries, $wgAmazonDirectTargetedBuyCountriesDefault;

		static $called = false;
		$code = '';

		if (!$called && self::isEnabled()) {
			$called = true;
			$countriesJS = [];

			$amazonCountries = $wgAmazonDirectTargetedBuyCountries;
			if (empty($amazonCountries)) {
				// If the variable is not set for given wiki, use the value from the community wiki
				$amazonCountries = WikiFactory::getVarValueByName(
					'wgAmazonDirectTargetedBuyCountries', Wikia::COMMUNITY_WIKI_ID
				);
			}
			if (empty($amazonCountries)) {
				// If the variable is set nor for given wiki neither for community, use the default value
				$amazonCountries = $wgAmazonDirectTargetedBuyCountriesDefault;
			}

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
