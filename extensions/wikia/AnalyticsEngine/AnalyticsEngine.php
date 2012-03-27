<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'AnalyticsEngine',
	'author' => 'Nick Sullivan'
);

interface iAnalyticsProvider {
	public function getSetupHtml($params=array());
	public function trackEvent($eventName, $eventDetails=array());
}

require_once dirname(__FILE__) . '/AnalyticsProviderQuantServe.php';
require_once dirname(__FILE__) . '/AnalyticsProviderGA_Urchin.php';
require_once dirname(__FILE__) . '/AnalyticsProviderComscore.php';
require_once dirname(__FILE__) . '/AnalyticsProviderExelate.php';

class AnalyticsEngine {

	const EVENT_PAGEVIEW = 'page_view';

	private $providers = array('GAT', 'GA_Urchin', 'QuantServe', 'MessageQueue');

	static public function track($provider, $event, $eventDetails=array(), $setupParams=array()){
		global $wgDevelEnvironment;
		global $wgNoExternals, $wgRequest;
		global $wgBlockedAnalyticsProviders;
		$wgNoExternals = $wgRequest->getBool('noexternals', $wgNoExternals);

		if ( !empty($wgBlockedAnalyticsProviders) && in_array($provider, $wgBlockedAnalyticsProviders) ) {
			return '<!-- AnalyticsEngine::track - ' . $provider . ' blocked via $wgBlockedAnalyticsProviders -->';
		}

		if ( !empty($wgDevelEnvironment) ) {
			return '<!-- DevelEnvironment -->';
		}

		if ( !empty($wgNoExternals) ) {
			return '<!-- AnalyticsEngine::track - externals disabled -->';
		}

		$AP = self::getProvider($provider);
		if (empty($AP)) {
			return '<!-- Invalid provider for AnalyticsEngine::getTrackCode -->';
		}
		$out = "<!-- Start for $provider, $event -->\n";
		$out .= $AP->getSetupHtml($setupParams);			
		$out .= $AP->trackEvent($event, $eventDetails) . "\n";
		return $out;
	}
	
	private static function getProvider($provider) {
		switch ($provider){
		  case 'GA_Urchin': $AP = new AnalyticsProviderGA_Urchin(); break;
		  case 'QuantServe': $AP = new AnalyticsProviderQuantServe(); break;
		  case 'Comscore': $AP = new AnalyticsProviderComscore(); break;
		  case 'Exelate': $AP = new AnalyticsProviderExelate(); break;
		  default: return null;
		}
		
		return $AP;
	}
}
