<?php

class AnalyticsProviderAmazonMatch implements iAnalyticsProvider {

	public static function isEnabled() {
		global $wgEnableAmazonMatch, $wgEnableAmazonMatchOld,
			$wgEnableAdEngineExt, $wgShowAds, $wgAdDriverUseSevenOneMedia;

		return ( $wgEnableAmazonMatch || $wgEnableAmazonMatchOld )
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

		if (ac && ac.indexOf && ac.indexOf(geo.getCountryCode()) > -1) {
			amazon.call();
		}
	});
CODE;

		return $code;
	}

	public function getSetupHtml( $params = array() ) {
		global $wgEnableAmazonMatch, $wgEnableAmazonMatchOld;

		static $called = false;

		if ( $called ) {
			return '';
		}

		$called = true;

		if ( !self::isEnabled() ) {
			return '';
		}

		if ( $wgEnableAmazonMatchOld ) {
			$oldScript = self::getIntegrationScript( 'amazonMatchOld', 'wgAmazonMatchOldCountries' );
		} else {
			$oldScript = '/* old integration disabled */';
		}

		if ( $wgEnableAmazonMatch ) {
			$newScript = self::getIntegrationScript( 'amazonMatch', 'wgAmazonMatchCountries' );
		} else {
			$newScript = '/* new integration disabled */';
		}

		return '<script id="analytics-provider-amazon-match">' . PHP_EOL .
			$oldScript . PHP_EOL .
			$newScript . PHP_EOL .
			'</script>' . PHP_EOL;
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}
