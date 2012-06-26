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
require_once dirname(__FILE__) . '/AnalyticsProviderGAS.php';

class AnalyticsEngine {

	const EVENT_PAGEVIEW = 'page_view';

	private $providers = array('GAT', 'GA_Urchin', 'QuantServe', 'MessageQueue', 'GAS');

	static public function track($provider, $event, $eventDetails=array(), $setupParams=array()){
		global $wgDevelEnvironment;
		global $wgNoExternals, $wgRequest;
		global $wgBlockedAnalyticsProviders;
		$wgNoExternals = $wgRequest->getBool('noexternals', $wgNoExternals);

		if ( !empty($wgBlockedAnalyticsProviders) && in_array($provider, $wgBlockedAnalyticsProviders) ) {
			return '<!-- AnalyticsEngine::track - ' . $provider . ' blocked via $wgBlockedAnalyticsProviders -->';
		}

		if ( !empty($wgDevelEnvironment) ) {
			$str = '<!-- DevelEnvironment -->';
			
			// To be able to test on dev-boxes, we need fake beacon and varnishTime values.
			// NOTE: DO NOT MOVE THIS INTO MakeGlobalVariables HOOK! These vars need to be defined in the exact same spot they would be defined if there was a real beacon call (and MakeGlobalVariables defines them way earlier).
			// Otherwise, things such as actual a/b tests could attempt to use the beacon before it's actually ready.  There would be a ton of race conditions, please don't move it to a differnt part of the HTML.
			static $fakeBeaconCalled = false;
			if((!$fakeBeaconCalled) && ($provider == "GA_Urchin")){
				$fakeBeaconCalled = true; // static is the same logic used to control the actual beacon being called exactly once.
				$beaconJs = "\n// For accurate testing, these must be set here (where the actual beacon call would be), not in global variables in the head tag.\n";
				$beaconJs .= "var beacon_id = 'ThisIsFake';\n"; // base 36, obviously-fake data so that devs don't get confused
				$beaconJs .= "var varnishTime = \"".date('r')."\";\n"; // Looks like "Wed, 09 May 2012 21:45:20 GMT" and is the RFC 2822 timestamp that varnish normally returns in the beacon/page-view call.
				$str .= "\n".Html::inlineScript( $beaconJs )."\n";
			}

			return $str;
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
		  case 'GA_Urchin': $AP = new AnalyticsProviderGAS(); break;
		  case 'QuantServe': $AP = new AnalyticsProviderQuantServe(); break;
		  case 'Comscore': $AP = new AnalyticsProviderComscore(); break;
		  case 'Exelate': $AP = new AnalyticsProviderExelate(); break;
		  case 'GAS': $AP = new AnalyticsProviderGAS; break;
		  default: return null;
		}
		
		return $AP;
	}
}
