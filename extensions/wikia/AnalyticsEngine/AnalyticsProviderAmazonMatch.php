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
		$moduleName = json_encode( $moduleName );
		$instantGlobalName = json_encode( $instantGlobalName );

		$code = <<< CODE
	require([$moduleName, "wikia.geo", "wikia.instantGlobals"], function (amazon, geo, globals) {
		var ac = globals[$instantGlobalName];

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
			$oldScript = self::getIntegrationScript( 'ext.wikia.adEngine.amazonMatchOld', 'wgAmazonMatchOldCountries' );
		} else {
			$oldScript = '/* old integration disabled */';
		}

		if ( $wgEnableAmazonMatch ) {
			$newScript = self::getIntegrationScript( 'ext.wikia.adEngine.amazonMatch', 'wgAmazonMatchCountries' );
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
