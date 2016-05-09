<?php

class AnalyticsProviderAmazonMatch implements iAnalyticsProvider {

	public static function isEnabled() {
		global $wgEnableAmazonMatch, $wgShowAds;

		return $wgEnableAmazonMatch
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
		require.optional($moduleName),
	], function (geo, globals, amazon) {
		var ac = globals[$instantGlobalName];

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
