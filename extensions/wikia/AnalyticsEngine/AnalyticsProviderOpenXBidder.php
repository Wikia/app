<?php

class AnalyticsProviderOpenXBidder implements iAnalyticsProvider {

	public static function isEnabled() {
		global $wgAdDriverEnableOpenXBidder, $wgShowAds;

		return $wgAdDriverEnableOpenXBidder
			&& $wgShowAds
			&& AdEngine2Service::areAdsShowableOnPage();
	}

	private function getIntegrationScript( $moduleName, $instantGlobalName ) {
		$moduleName = json_encode( 'ext.wikia.adEngine.lookup.' . $moduleName );
		$instantGlobalName = json_encode( $instantGlobalName );

		$code = <<< CODE
	require([
		"wikia.geo",
		"wikia.querystring",
		"wikia.instantGlobals",
		require.optional($moduleName)
	], function (geo, Querystring, globals, oxBidder) {
		var ac = globals[$instantGlobalName],
			qs = new Querystring();

		if (geo.isProperGeo(ac) || qs.getVal('oxbidder', '0') === '1') {
			oxBidder.call();
		};
	});
CODE;

		return $code;
	}

	public function getSetupHtml( $params = array() ) {
		global $wgAdDriverEnableOpenXBidder;

		static $called = false;

		if ( $called ) {
			return '';
		}

		$called = true;

		if ( !self::isEnabled() ) {
			return '';
		}

		if ( $wgAdDriverEnableOpenXBidder ) {
			$oxScript = self::getIntegrationScript( 'openXBidder', 'wgAdDriverOpenXBidderCountries' );
		} else {
			$oxScript = '/* OpenX Bidder integration disabled */';
		}

		return '<script id="analytics-provider-openx-bidder">' . PHP_EOL .
			$oxScript . PHP_EOL .
			'</script>' . PHP_EOL;
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}
