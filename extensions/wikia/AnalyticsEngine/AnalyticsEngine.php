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
		switch ($provider){
		  case 'GA_Urchin': $AP = new AnalyticsProviderGAS(); break;
		  case 'QuantServe': $AP = new AnalyticsProviderQuantServe(); break;
		  case 'Comscore': $AP = new AnalyticsProviderComscore(); break;
		  case 'Exelate': $AP = new AnalyticsProviderExelate(); break;
		  case 'GAS': $AP = new AnalyticsProviderGAS; break;
		  case 'IVW': $AP = new AnalyticsProviderIVW; break;
		  default: return null;
		}

		return $AP;
	}
}
