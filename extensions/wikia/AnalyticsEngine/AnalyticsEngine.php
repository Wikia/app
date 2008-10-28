<?php
$wgExtensionCredits['other'][] = array(
	'name' => 'AnalyticsEngine',
	'author' => 'Nick Sullivan'
);

interface iAnalyticsProvider {
	public function getSetupHtml();
	public function trackEvent($eventName, $eventDetails=array());
}

require 'AnalyticsProviderQuantServe.php';
require 'AnalyticsProviderGA_Urchin.php';

class AnalyticsEngine {

	const EVENT_PAGEVIEW = 'page_view';

	private $providers = array('GAT', 'GA_Urchin', 'QuantServe', 'MessageQueue');

	static public function track($provider, $event, $eventDetails=array()){
		switch ($provider){
	//	  case 'GAT': $AP = new AnalyticsProviderGAT(); break;
		  case 'GA_Urchin': $AP = new AnalyticsProviderGA_Urchin(); break;
		  case 'QuantServe': $AP = new AnalyticsProviderQuantServe(); break;
	//	  case 'MessageQueue': $AP = new AnalyticsProviderMessageQueue(); break;
		  default: return '<!-- Invalid provider for AnalyticsEngine::getTrackCode -->';
		}

		$out = "<!-- Start for $provider, $event -->\n";
		$out .= $AP->getSetupHtml() . "\n";
		$out .= $AP->trackEvent($event, $eventDetails) . "\n";
		$out .= "<!-- End tracking code for $provider, $event -->\n";
		return $out;
	}

}
