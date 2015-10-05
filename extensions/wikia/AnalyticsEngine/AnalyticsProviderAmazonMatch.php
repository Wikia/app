<?php

class AnalyticsProviderAmazonMatch implements iAnalyticsProvider {

	public static function isEnabled() {
		global $wgEnableAmazonMatch, $wgEnableAdEngineExt, $wgShowAds, $wgAdDriverUseSevenOneMedia;

		return ( $wgEnableAmazonMatch )
			&& $wgEnableAdEngineExt
			&& $wgShowAds
			&& AdEngine2Service::areAdsShowableOnPage()
			&& !$wgAdDriverUseSevenOneMedia;
	}

	private function getIntegrationScript( $moduleName, $instantGlobalName ) {
		$moduleName1 = json_encode( 'ext.wikia.adEngine.lookup.' . $moduleName );
		$moduleName2 = json_encode( 'ext.wikia.adEngine.' . $moduleName );
		$instantGlobalName = json_encode( $instantGlobalName );

		$code = <<< CODE
	require([
		"wikia.geo",
		"wikia.instantGlobals",
		require.optional($moduleName1), // new name
		require.optional($moduleName2)  // old name
	], function (geo, globals, amazon1, amazon2) {
		var ac = globals[$instantGlobalName],
			amazon = amazon1 || amazon2;

		if (geo.isProperGeo(ac)) {
			amazon.call();
		}
	});
CODE;

		return $code;
	}

	public function getSetupHtml( $params = array() ) {
		global $wgEnableAmazonMatch;

		static $called = false;

		if ( $called ) {
			return '';
		}

		$called = true;

		if ( !self::isEnabled() ) {
			return '';
		}

		if ( $wgEnableAmazonMatch ) {
			$newScript = self::getIntegrationScript( 'amazonMatch', 'wgAmazonMatchCountries' );
		} else {
			$newScript = '/* new integration disabled */';
		}

		return '<script id="analytics-provider-amazon-match">' . PHP_EOL .
			$newScript . PHP_EOL .
			'</script>' . PHP_EOL;
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}
