<?php

class AnalyticsProviderDfpSniffer implements iAnalyticsProvider {

	public static function isEnabled() {
		global $wgAdDriverEnableDfpSniffer, $wgEnableAdEngineExt, $wgShowAds, $wgAdDriverUseSevenOneMedia;

		return ( $wgAdDriverEnableDfpSniffer )
		&& $wgEnableAdEngineExt
		&& $wgShowAds
		&& AdEngine2Service::areAdsShowableOnPage()
		&& !$wgAdDriverUseSevenOneMedia;
	}

	private function getIntegrationScript( $moduleName ) {
		$moduleName = json_encode( 'ext.wikia.adEngine.lookup.' . $moduleName );

		$code = <<< CODE
	require([
		require.optional($moduleName)
	], function (dfpSniffer) {
		if (dfpSniffer) {
			dfpSniffer.init();
		}
	});
CODE;

		return $code;
	}

	public function getSetupHtml( $params = array() ) {
		global $wgAdDriverEnableDfpSniffer;

		static $called = false;

		if ( $called ) {
			return '';
		}

		$called = true;

		if ( !self::isEnabled() ) {
			return '';
		}

		if ( $wgAdDriverEnableDfpSniffer ) {
			$oxScript = self::getIntegrationScript( 'dfpSniffer' );
		} else {
			$oxScript = '/* DFP Sniffer disabled */';
		}

		return '<script id="analytics-provider-dfp-sniffer">' . PHP_EOL .
		$oxScript . PHP_EOL .
		'</script>' . PHP_EOL;
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}
