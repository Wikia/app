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
	(function () {
		var geo = require('wikia.geo'),
			globals = require('wikia.instantGlobals'),
			amazon,
			ac = globals[$instantGlobalName];

			try {
				// new name
				amazon1 = require($moduleName1);
			} catch (exception) {
				amazon1 = null;
			}

			try {
				// old name
				amazon2 = require($moduleName2);
			} catch (exception) {
				amazon2 = null;
			}

			amazon = amazon1 || amazon2;

		if (geo.isProperGeo(ac)) {
			amazon.call();
		}
	})();
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
