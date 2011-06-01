<?php

class AnalyticsProviderAperture implements iAnalyticsProvider {
	private static $LIVECON_CLIENT_ID = 4651450754457;
	private static $NONSECURE_SCRIPT_HOST = 'http://edge.aperture';
	private static $SECURE_SCRIPT_HOST = 'https://xedge.aperture';
	private static $NONSECURE_IMAGE_HOST = 'http://aperture';
	private static $SECURE_IMAGE_HOST = 'https://secure.aperture';
	
	private $pageId;
	private $scriptHost;
	private $imageHost;
	
	function __construct() {
		global $wgCityId;
		
		$this->pageId = HubService::getAperturePageId($wgCityId);		
		
		$urlParts = wfGetCurrentUrl();
		if ($urlParts['scheme'] == 'https') {
			$this->scriptHost = self::$SECURE_SCRIPT_HOST;
			$this->imageHost = self::$SECURE_IMAGE_HOST;
		}		
		else {
			$this->scriptHost = self::$NONSECURE_SCRIPT_HOST;
			$this->imageHost = self::$NONSECURE_IMAGE_HOST;			
		}
	}
	
	function getSetupHtml(){
		return null;
	}

	function trackEvent($event, $eventDetails=array()){
		switch ($event){
		  case AnalyticsEngine::EVENT_PAGEVIEW : return '
<!-- Begin Aperture Tag -->
<script language="JavaScript" src="'.$this->scriptHost.'.displaymarketplace.com/displayscript.js?liveconclientID='.self::$LIVECON_CLIENT_ID.'&PageID='.$this->pageId.'"></script>
<noscript>
<img src="'.$this->imageHost.'.displaymarketplace.com/audmeasure.gif?liveconclientID='.self::$LIVECON_CLIENT_ID.'&PageID='.$this->pageId.'&EventType=view" height="1" width="1"border="0" />
</noscript>
<!-- End Aperture Tag -->';
			break;
                  default: return '<!-- Unsupported event for ' . __CLASS__ . ' -->';
		}
	}
}
