<?php

class AnalyticsProviderRubiconFastlane implements iAnalyticsProvider {

	public static function isEnabled() {
		global $wgAdDriverEnableRubiconFastlane, $wgShowAds;

		return $wgAdDriverEnableRubiconFastlane
			&& $wgShowAds
			&& AdEngine2Service::areAdsShowableOnPage();
	}

	private function getIntegrationScript( $moduleName, $instantGlobalName ) {
		$moduleName = json_encode( 'ext.wikia.adEngine.lookup.' . $moduleName );
		$instantGlobalName = json_encode( $instantGlobalName );

		$code = <<< CODE
	require([
		"wikia.geo",
		"wikia.instantGlobals",
		require.optional($moduleName)
	], function (geo, instantGlobals, rubiconFastlane) {
		if (geo.isProperGeo(instantGlobals[$instantGlobalName])) {
			rubiconFastlane.call();
		};
	});
CODE;

		return $code;
	}

	public function getSetupHtml( $params = array() ) {
		global $wgAdDriverEnableRubiconFastlane;

		static $called = false;

		if ( $called ) {
			return '';
		}

		$called = true;

		if ( !self::isEnabled() ) {
			return '';
		}

		if ( $wgAdDriverEnableRubiconFastlane ) {
			$rubiconScript = self::getIntegrationScript( 'rubiconFastlane', 'wgAdDriverRubiconFastlaneCountries' );
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
