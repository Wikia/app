<?php

class AnalyticsProviderSourcePoint implements iAnalyticsProvider {

	public static function isEnabled() {
		return ARecoveryModule::isEnabled();
	}

	public function getSetupHtml( $params = array() ) {
		if ( !static::isEnabled() ) {
			return '';
		}

		$sourcePointScript = F::app()->sendRequest( 'ARecoveryEngineApiController', 'getBootstrap' );


		return '<script id="analytics-provider-source-point">' . PHP_EOL .
			$sourcePointScript . PHP_EOL .
		'</script>' . PHP_EOL;
	}

	public function trackEvent( $event, $eventDetails = array() ) {
		return '';
	}
}
