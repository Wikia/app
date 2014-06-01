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
			case 'GA_Urchin':
				return new AnalyticsProviderGAS();
			case 'QuantServe':
				return new AnalyticsProviderQuantServe();
			case 'Comscore':
				return new AnalyticsProviderComscore();
			case 'Exelate':
				return new AnalyticsProviderExelate();
			case 'GAS':
				return new AnalyticsProviderGAS();
			case 'IVW':
				return new AnalyticsProviderIVW();
			case 'AmazonDirectTargetedBuy':
				return new AnalyticsProviderAmazonDirectTargetedBuy();
			case 'DynamicYield':
				return new AnalyticsProviderDynamicYield();
		}

		return null;
	}
}
