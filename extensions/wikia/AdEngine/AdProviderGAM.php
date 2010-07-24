<?php

/* Provider class for Google Ad Manager.
 * Documentation:
 * https://www.google.com/admanager/help/en_US/tips/tagging.html
 *
 * Debug: Try adding ?google_debug to the url.
 *
 */

class AdProviderGAM implements iAdProvider {

	protected static $instance = false;
	private $provider_id = 4;

	public $iframeRendering = true; // Toggle iframes/non iframes

	//private $adManagerId = "ca-pub-3862144315477646"; gorillamania@gmail.com account
	public $adManagerId = "ca-pub-4086838842346968"; // Wikia account

	public $batchHtmlCalled = false, $setupHtmlCalled = false;

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdProviderGAM();
		}
		return self::$instance;
	}

	// TODO : Make this an assoc array with the bucket name
	private $channels = array(	'1089383293', // Control
					'7297263620', // Unused
					'7102419657', // Unused
					'3156555836', // Default colors (instead of matching colors to the wiki)
					'9000659297', // Unused
					'5796745449', // Unused
					'4441240368'); // Unused

	private $slotsToCall = array();

	public function addSlotToCall($slotname){
		$this->slotsToCall[]=$slotname;
	}

	public function batchCallAllowed(){
		return true;
	}

        public function getSetupHtml(){
		if ($this->setupHtmlCalled){
			return false;
		}
		$this->setupHtmlCalled = true;

		$out = "<!-- ## BEGIN " . __CLASS__ . '::' . __METHOD__ . " ## -->\n";
		// Download the necessary required javascript
		
		$out .= '<script type="text/javascript" src="http://partner.googleadservices.com/gampad/google_service.js"></script>' . "\n" .
			// Set up a try/catch to see if the user has AdBlock enabled presumably because the above call failed to download
			'<script type="text/javascript">
			wgAdBlockEnabled=false;
			GS_googleAddAdSenseService("' . $this->adManagerId . '");
			GS_googleEnableAllServices();' . "\n" .
			'</script>';
		if ($this->iframeRendering){ 
			// I had to ask to have this enabled
			$out.= '<script type="text/javascript">GA_googleUseIframeRendering();' . "</script>";
		}
		$out .= "<!-- ## END " . __CLASS__ . '::' . __METHOD__ . " ## -->\n";
		return $out;
        }


	/* This function batches all of the ads to be called into one round trip. 
	 * GA_googleFillSlot is what actually calls the ads.
	 */
	public function getBatchCallHtml(){
		global $wgUser;

		$this->batchHtmlCalled = true;

		$out = "<!-- ## BEGIN " . __CLASS__ . '::' . __METHOD__ . " ## -->\n";
		
		// Make a call for each slot.
		$this->slotsToCall = AdEngine::getInstance()->getSlotNamesForProvider($this->provider_id);

		$out .= '<script type="text/javascript">' . "\n";
		if (! $this->iframeRendering){ 
			foreach ( $this->slotsToCall as $slotname ){
				$out .= 'GA_googleAddSlot("' . $this->adManagerId . '","' . $slotname . '");' . "\n";
				// Set up key values
				$out .= $this->getProviderValues($slotname);
			}
		}

		// ###### Our custom key values
		// Always pass the hub as a key value
		$out .= $this->getTargetingValue('hub', $this->getHub()) . "\n";
		// And skin
		if (is_object($wgUser)){
			$out .= $this->getTargetingValue('skin_name', $wgUser->getSkin()->getSkinName()) . "\n";
		}
		// And languages
		$out .= 'GA_googleAddAttr("cont_lang", wgContentLanguage);' . "\n";
		$out .= 'GA_googleAddAttr("user_lang", wgUserLanguage);' . "\n";
		
		// And dbname
		$out .= 'GA_googleAddAttr("dbname", wgDB);' . "\n";

		// ###### Ad Sense attributes
		$out .= $this->getAdSenseAttr() . "\n" .
			'</script>' . "\n";
		
		// Make the call for all the ads
		if (! $this->iframeRendering){ 
			$out .= '<script type="text/javascript">GA_googleFetchAds();</script>' . "\n";
		}
		

		$out .= "<!-- ## END " . __CLASS__ . '::' . __METHOD__ . " ## -->\n";
		return $out;	
	}


	/* Passing google ad sense attributes. The google ad sense attributes aren't very well documented.
	 * This page seems to have quite a few.  http://gandolf.homelinux.org/~smhanov/blog/?id=21
	 * Use Google Channels for bucket testing of different attributes.
         */
	public function getAdSenseAttr(){

		$channel = $this->getChannel();
		$out = '';

		global $wgUser;
		$skin_name = null;
		if (is_object($wgUser)){
			$skin_name = $wgUser->getSkin()->getSkinName();
		}
		if ($channel != "3156555836" && $skin_name == 'monaco' ){
			// Set the colors to match the wiki, except for "3156555836", which is testing white
			// This is only available in monaco
			$out .= 'GA_googleAddAdSensePageAttr("google_color_border", AdEngine.getAdColor("text"));' . "\n";
			$out .= 'GA_googleAddAdSensePageAttr("google_color_bg", AdEngine.getAdColor("bg"));' . "\n";
			$out .= 'GA_googleAddAdSensePageAttr("google_color_link", AdEngine.getAdColor("link"));' . "\n";
			$out .= 'GA_googleAddAdSensePageAttr("google_color_text", AdEngine.getAdColor("text"));' . "\n";
			$out .= 'GA_googleAddAdSensePageAttr("google_color_url", AdEngine.getAdColor("url"));' . "\n";
		}

		$out .= 'GA_googleAddAdSensePageAttr("google_ad_channel", "' . $channel . '");' . "\n";
		// Pass the page url. This proved to help eCPM in bucket tests.
		$out .= 'GA_googleAddAdSensePageAttr("google_page_url", "' . addslashes(AdProviderGoogle::getPageUrl()) . '");' . "\n";
		// Pass the language of the wiki. This proved to perform the best in bucket tests
		$out .= 'GA_googleAddAdSensePageAttr("google_language", wgContentLanguage);' . "\n";

		// Bucket testing of different params based on channel
		switch ($channel){
		  case '1089383293': break; //control
		  case '3156555836': break; // Testing white backgrounds 
		  case '9000659297': break; // Unused
		  case '4441240368': break; // Unused
		  case '7102419657': break; // Unused
		  case '7297263620': break; // Unused
		  case '5796745449': break; // Unused
		  default: trigger_error("Unrecognized Google Channel ($channel)", E_USER_WARNING);
                }

		return $out;
	}

        public function getChannel(){
                // Channel is a way to do bucket testing.
                static $channel;
                if (!empty($channel)){
                        return $channel;
                }

		$rand = mt_rand(0, sizeof($this->channels)-1);
		$channel = $this->channels[$rand];
                return $channel;
        }



	public function getAd($slotname, $slot){
		$out = "";
		// First time the ad is called, call all the batch code, if it hasn't already been called.
		if (! $this->setupHtmlCalled){
			$out .= $this->getSetupHtml();
		} 
		if (! $this->batchHtmlCalled){
			$out .= $this->getBatchCallHtml();
		} 

		$dim = AdEngine::getHeightWidthFromSize($slot['size']);

		if ($this->iframeRendering){
			// I had to ask them to get this turned on
			$args = array($this->adManagerId, $slotname, $dim['width'], $dim['height']);
			return $out . '<script type="text/javascript">GA_googleFillSlotWithSize("' . implode('","', $args) . '");</script>';
		} else {
			return $out . '<script type="text/javascript">GA_googleFillSlot("' . $slotname . '")</script>';
		}
	}


	private function getHub(){
		$cat=AdEngine::getCachedCategory();
				return $cat['short'];
	}


	private function getProviderValues($slot){
		if(empty($slot['provider_values']) || !is_array($slot['provider_values'])){
			return '';
		}

		$out = '';
		foreach ($slot['provider_values'] as $keyname => $keyvalue){
			$out .= $this->getTargetingValue($keyname, $keyvalue) . "\n";
		}
		return $out;
	}


	/* From Google Doc:
	 * Key names and key values may contain up to 10 characters each.
	 * You may only use alphanumeric characters, underscores, and hyphens.
	 */
	function getTargetingValue($keyname, $keyvalue){
		static $alreadyCalled = array();

		// Google Ad Manager doesn't support per-slot values, so no need to call the same one more than once.
		if (isset($alreadyCalled[$keyname])){
			return false;
		}
		$alreadyCalled[$keyname]=true;

		$keyname = preg_replace('/[^a-z0-9A-Z\-_]/', '', $keyname); // alnum only
		$keyname = substr($keyname, 0, 10); // limited to 10 chars
		$keyvalue = preg_replace('/[^a-z0-9A-Z\-_]/', '', $keyvalue); // alnum only
		$keyvalue = substr($keyvalue, 0, 10); // limited to 10 chars

		return 'GA_googleAddAttr("' . addslashes($keyname) . '","' . addslashes($keyvalue) . '");';
	}

}

