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
		return F::app()->wg->EnableAmazonDirectTargetedBuy
			&& F::app()->wg->AmazonDirectTargetedBuyCountries
			&& F::app()->wg->ShowAds
			&& AdEngine2Controller::areAdsShowableOnPage()
			&& !F::app()->wg->wgAdDriverUseSevenOneMedia;
	}

	public function getSetupHtml($params = array()) {
		static $called = false;

		$code = '';
		$countries = [];

		foreach (F::app()->wg->AmazonDirectTargetedBuyCountries as $countryCode) {
			$countries[$countryCode] = true;
		}

		if (!$called) {
			$called = true;

			if (self::isEnabled()) {
				$code = str_replace('%%COUNTRIES%%', json_encode($countries), self::$code);
			}
		}

		return $code;
	}

	public function trackEvent($event, $eventDetails = array()) {
		return '';
	}
}
