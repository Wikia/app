<?php
class AnalyticsEngine {

	const EVENT_PAGEVIEW = 'page_view';

	/**
	 * Returns HTML with tracking code from a given analytics provider
	 *
	 * @param string $provider
	 * @param string $event
	 * @param array $eventDetails
	 * @param array $setupParams
	 * @return string
	 */
	static public function track( $provider, $event, Array $eventDetails = [], Array $setupParams = [] ) {
		global $wgNoExternals, $wgRequest;
		global $wgBlockedAnalyticsProviders;
		$wgNoExternals = $wgRequest->getBool( 'noexternals', $wgNoExternals );

		if ( !empty( $wgBlockedAnalyticsProviders ) && in_array( $provider, $wgBlockedAnalyticsProviders ) ) {
			return '<!-- AnalyticsEngine::track - ' . $provider . ' blocked via $wgBlockedAnalyticsProviders -->';
		}

		if ( !empty( $wgNoExternals ) ) {
			return '<!-- AnalyticsEngine::track - externals disabled -->';
		}

		try {
			$AP = self::getProvider( $provider );
		} catch ( Exception $e ) {
			return '<!-- Invalid provider for AnalyticsEngine::getTrackCode -->';
		}

		$out = $AP->getSetupHtml( $setupParams );

		if ( !empty( $out ) ) {
			$out = "\n<!-- Start for $provider, $event -->\n" . $out;
		}

		$out .= $AP->trackEvent( $event, $eventDetails );
		return $out;
	}

	/**
	 * Returns an instance of given analytics provider
	 *
	 * @param string $provider
	 * @return iAnalyticsProvider
	 *
	 * @throws Exception
	 */
	private static function getProvider( $provider ) {
		$className = "AnalyticsProvider{$provider}";
		return new $className();
	}
}
