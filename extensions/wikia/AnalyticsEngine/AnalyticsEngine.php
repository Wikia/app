<?php
class AnalyticsEngine {

	const EVENT_PAGEVIEW = 'page_view';

	static public function track($provider, $event, $eventDetails=array(), $setupParams=array()){
		global $wgNoExternals, $wgRequest;
		global $wgBlockedAnalyticsProviders;
		$wgNoExternals = $wgRequest->getBool('noexternals', $wgNoExternals);

		if ( !empty($wgBlockedAnalyticsProviders) && in_array($provider, $wgBlockedAnalyticsProviders) ) {
			return '<!-- AnalyticsEngine::track - ' . $provider . ' blocked via $wgBlockedAnalyticsProviders -->';
		}

		if ( !empty($wgNoExternals) ) {
			return '<!-- AnalyticsEngine::track - externals disabled -->';
		}

		$AP = self::getProvider($provider);
		if (empty($AP)) {
			return '<!-- Invalid provider for AnalyticsEngine::getTrackCode -->';
		}

		$out = $AP->getSetupHtml($setupParams);

		if ( !empty( $out ) ) {
			$out = "\n<!-- Start for $provider, $event -->\n" . $out;
		}

		$out .= $AP->trackEvent($event, $eventDetails);
		return $out;
	}

	private static function getProvider($provider) {
		switch ($provider) {
			case 'QuantServe':
				return new AnalyticsProviderQuantServe();
			case 'Comscore':
				return new AnalyticsProviderComscore();
			case 'Exelate':
				return new AnalyticsProviderExelate();
			case 'GoogleFundingChoices':
				return new AnalyticsProviderGoogleFundingChoices();
			case 'GoogleUA':
				return new AnalyticsProviderGoogleUA();
			case 'Krux':
				return new AnalyticsProviderKrux();
			case 'A9':
				return new AnalyticsProviderA9();
			case 'Nielsen':
				return new AnalyticsProviderNielsen();
			case 'Prebid':
				return new AnalyticsProviderPrebid();
			case 'DynamicYield':
				return new AnalyticsProviderDynamicYield();
			case 'NetzAthleten':
				return new AnalyticsProviderNetzAthleten();
		}

		return null;
	}
}
