<?php

class AnalyticsProviderRubiconFastlane implements iAnalyticsProvider {

	public static function isEnabled() {
		global $wgAdDriverEnableOpenXBidder, $wgEnableAdEngineExt, $wgShowAds, $wgAdDriverUseSevenOneMedia;

		return ( true )
			&& $wgEnableAdEngineExt
			&& $wgShowAds
			&& AdEngine2Service::areAdsShowableOnPage()
			;
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
	], function (geo, Querystring, globals, rubiconFastlane) {
		rubiconFastlane.call('oasis');
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
			$rubiconScript = self::getIntegrationScript( 'rubiconFastlane', 'wgAdDriverOpenXBidderCountries' );
		} else {
			$rubiconScript = '/* Rubicon Fastlane integration disabled */';
		}

		return '<script id="analytics-provider-rubicon-fastlane">' . PHP_EOL .
			$rubiconScript . PHP_EOL .
			'</script>' . PHP_EOL;
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}
