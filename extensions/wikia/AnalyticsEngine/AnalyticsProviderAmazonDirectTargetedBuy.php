<?php

class AnalyticsProviderAmazonDirectTargetedBuy implements iAnalyticsProvider {

	private static $code = <<< SCRIPT
		<script>
			require(['wikia.geo'], function (geo) {
				if (geo.getCountryCode() === 'US') {
					var aax_src='3006';
					var aax_url = encodeURIComponent(document.location);
					try { aax_url = encodeURIComponent("" + window.top.location); } catch(e) {}
					var s = document.createElement('script');
					s.type = 'text/javascript';
					s.async = true;
					s.src = '//aax-us-east.amazon-adsystem.com/e/dtb/bid?src=' + aax_src + '&u=' + aax_url + "&cb=" + Math.round(Math.random()*10000000);
					var insertLoc = document.getElementsByTagName('script')[0];
					insertLoc.parentNode.insertBefore(s, insertLoc);
				}
			});
		</script>
SCRIPT;

	public static function isEnabled() {
		return F::app()->wg->EnableAmazonDirectTargetedBuy
			&& F::app()->wg->ShowAds
			&& AdEngine2Controller::areAdsShowableOnPage();
	}

	public function getSetupHtml($params = array()) {
		static $called = false;

		$code = '';

		if (!$called) {
			$called = true;

			if (self::isEnabled()) {
				$code = self::$code;
			}
		}

		return $code;
	}

	public function trackEvent($event, $eventDetails = array()) {
		return '';
	}
}
