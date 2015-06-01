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
			case 'GoogleUA':
				return new AnalyticsProviderGoogleUA();
			case 'AmazonMatch':
				return new AnalyticsProviderAmazonMatch();
			case 'DynamicYield':
				return new AnalyticsProviderDynamicYield();
			case 'IVW2':
				return new AnalyticsProviderIVW2();
			case 'BlueKai':
				return new AnalyticsProviderBlueKai();
			case 'Datonics':
				return new AnalyticsProviderDatonics();
			case 'PageFair':
				return new AnalyticsProviderPageFair();
			case 'RubiconRTP':
				return new AnalyticsProviderRubiconRTP();
		}

		return null;
	}
}
