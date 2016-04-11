<?php

class AnalyticsProviderSpeedBidder implements iAnalyticsProvider {

	public static function isEnabled() {
		global $wgAdDriverEnableOpenXSpeedBidder, $wgEnableAdEngineExt, $wgShowAds, $wgAdDriverUseSevenOneMedia;

		return ( $wgAdDriverEnableOpenXSpeedBidder )
			&& $wgEnableAdEngineExt
			&& $wgShowAds
			&& AdEngine2Service::areAdsShowableOnPage()
			&& !$wgAdDriverUseSevenOneMedia;
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
	], function (geo, Querystring, globals, speedBidder) {
		var ac = globals[$instantGlobalName],
			qs = new Querystring();

		if (geo.isProperGeo(ac) || qs.getVal('speedbidder', '0') === '1') {
			speedBidder.call();
		};
	});
CODE;

		return $code;
	}

	public function getSetupHtml( $params = array() ) {
		global $wgAdDriverEnableOpenXSpeedBidder;

		static $called = false;

		if ( $called || !self::isEnabled() ) {
			return '';
		}

		$called = true;

		$speedBidderScript = $wgAdDriverEnableOpenXSpeedBidder ? self::getIntegrationScript( 'speedBidder', 'wgAdDriverOpenXSpeedBidderCountries' ) : '/* SpeedBidder integration disabled */';

		return '<script id="analytics-provider-speed-bidder">' . PHP_EOL .
			$speedBidderScript . PHP_EOL .
			'</script>' . PHP_EOL;
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}
