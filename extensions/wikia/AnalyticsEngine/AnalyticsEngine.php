<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'AnalyticsEngine',
	'author' => 'Nick Sullivan'
);

interface iAnalyticsProvider {
	public function getSetupHtml();
	public function trackEvent($eventName, $eventDetails=array());
}

require_once dirname(__FILE__) . '/AnalyticsProviderQuantServe.php';
require_once dirname(__FILE__) . '/AnalyticsProviderGA_Urchin.php';
require_once dirname(__FILE__) . '/AnalyticsProviderComscore.php';
require_once dirname(__FILE__) . '/AnalyticsProviderExelate.php';

class AnalyticsEngine {

	const EVENT_PAGEVIEW = 'page_view';

	private $providers = array('GAT', 'GA_Urchin', 'QuantServe', 'MessageQueue');

	static public function track($provider, $event, $eventDetails=array()){
		global $wgDevelEnvironment;
		global $wgNoExternals, $wgRequest;
		$wgNoExternals = $wgRequest->getBool('noexternals', $wgNoExternals);

		if ( !empty($wgDevelEnvironment) ) {
			return '<!-- DevelEnvironment -->';
		}
		
		if ( !empty($wgNoExternals) ) {
			return '<!-- AnalyticsEngine::track - externals disabled -->';
		}

		switch ($provider){
	//	  case 'GAT': $AP = new AnalyticsProviderGAT(); break;
		  case 'GA_Urchin': $AP = new AnalyticsProviderGA_Urchin(); break;
		  case 'QuantServe': $AP = new AnalyticsProviderQuantServe(); break;
		  case 'Comscore': $AP = new AnalyticsProviderComscore(); break;
	//	  case 'MessageQueue': $AP = new AnalyticsProviderMessageQueue(); break;
		  case 'Exelate': $AP = new AnalyticsProviderExelate(); break;
		  default: return '<!-- Invalid provider for AnalyticsEngine::getTrackCode -->';
		}

		$out = "<!-- Start for $provider, $event -->\n";
		$out .= $AP->getSetupHtml();
		$out .= $AP->trackEvent($event, $eventDetails) . "\n";
		return $out;
	}

}
