<?php

class AnalyticsProviderAmazonDirectTargetedBuy implements iAnalyticsProvider {

	private static $code = <<< SCRIPT
		<script>
			require(['wikia.geo'], function (geo) {
				if (window.wgAmazonDirectTargetedBuyCountries && wgAmazonDirectTargetedBuyCountries.indexOf(geo.getCountryCode()) > -1) {
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
		static $called = false;
		$code = '';

		if (!$called && self::isEnabled()) {
			$code = self::$code;
		}

		return $code;
	}

	public function trackEvent($event, $eventDetails = array()) {
		return '';
	}
}
