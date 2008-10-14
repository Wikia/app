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

	private $adManagerId = "ca-pub-3862144315477646";

	public $batchHtmlCalled = false;

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdProviderGAM();
		}
		return self::$instance;
	}

	private $sites = array(	'Auto' => 'auto',
				'Creative' => 'crea',
				'Education' => 'edu',
				'Entertainment' => 'ent',
				'Finance' => 'fin',
				'Gaming' => 'gaming',
				'Green' => 'green',
				'Humor' => 'humor',
				'Lifestyle' => 'life',
				'Music' => 'music',
				'Philosophy' => 'phil',
				'Politics' => 'poli',
				'Science' => 'sci',
				'Sports' => 'sports',
				'Technology' => 'tech',
				'Test Site' => 'test',
				'Toys' => 'toys',
				'Travel' => 'travel');

	private $channels = array(	'8770790322', // Control
					'1816018796', // Content Language
					'1561126031', // User Language
					'6359157529', // Default colors (instead of matching colors to the wiki)
					'2086936532', // Hints
					'4120043396', // Keywords
					'2695313814'); // Page Url

	private $slotsToCall = array();

	public function addSlotToCall($slotname){
		$this->slotsToCall[]=$slotname;
	}

	public function batchCallAllowed(){
		return true;
	}

        public function getSetupHtml(){
		static $called = false;
		if ($called){
			return false;
		}
		$called = true;

		$out = "<!-- ## BEGIN " . __CLASS__ . '::' . __METHOD__ . " ## -->\n";
		// Download the necessary required javascript
		
		$out .= '<script type="text/javascript" src="http://partner.googleadservices.com/gampad/google_service.js"></script>' . "\n" .
			'<script type="text/javascript">' . "\n" . 
			'GS_googleAddAdSenseService("' . $this->adManagerId . '");' . "\n" . 
			'GS_googleEnableAllServices();' . "\n" .
			'</script>' . "\n";
		$out .= "<!-- ## END " . __CLASS__ . '::' . __METHOD__ . " ## -->\n";
		return $out;
        }


	/* This function batches all of the ads to be called into one round trip. 
	 * GA_googleFillSlot is what actually calls the ads.
	 */
	public function getBatchCallHtml(){

		$this->batchHtmlCalled = true;

		$out = "<!-- ## BEGIN " . __CLASS__ . '::' . __METHOD__ . " ## -->\n";
		
		// Make a call for each slot.
		$out .= '<script type="text/javascript">';
		foreach ( $this->slotsToCall as $slotname ){
			$out .= 'GA_googleAddSlot("' . $this->adManagerId . '","' . $slotname . '");' . "\n";
			// Set up key values
			$out .= $this->getProviderValues($slotname);
		}

		// ###### Our custom key values
		// Always pass the hub as a key value
		$out .= $this->getTargetingValue('hub', $this->getHub()) . "\n";
		// And languages
		$out .= 'GA_googleAddAttr("cont_lang", wgContentLanguage);' . "\n";
		$out .= 'GA_googleAddAttr("user_lang", wgUserLanguage);' . "\n";

		// ###### Ad Sense attributes
		$out .= $this->getAdSenseAttr();
		$out .= '</script>' . "\n";
		
		// Make the call for all the ads
		$out .= '<script type="text/javascript">GA_googleFetchAds()</script>' . "\n";
		

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

		if ($channel != "6359157529"){
			// Set the colors to match the wiki, except for "6359157529", which is testing white
			$out .= 'GA_googleAddAdSensePageAttr("google_color_border", AdEngine.getAdColor("text"));' . "\n";
			$out .= 'GA_googleAddAdSensePageAttr("google_color_bg", AdEngine.getAdColor("bg"));' . "\n";
			$out .= 'GA_googleAddAdSensePageAttr("google_color_link", AdEngine.getAdColor("link"));' . "\n";
			$out .= 'GA_googleAddAdSensePageAttr("google_color_text", AdEngine.getAdColor("text"));' . "\n";
			$out .= 'GA_googleAddAdSensePageAttr("google_color_url", AdEngine.getAdColor("url"));' . "\n";
		}

                if (in_array(AdEngine::getInstance()->getBucketName(), array('lp', 'lp_at', 'bp'))){
			$out .= 'GA_googleAddAdSensePageAttr("google_ad_channel", AdEngine.getGoogleChannel());' . "\n";
                        // Stop here, because these are doing bucket tests in javascript
			return $out;
		}       

		$out .= 'GA_googleAddAdSensePageAttr("google_ad_channel", "' . $channel . '");' . "\n";


		// Bucket testing of different params based on channel
		switch ($channel){
		  case '8770790322': break; //control
		  case '6359157529': // Testing white backgrounds 
		  case '2086936532':
			if(!empty($_GET['search'])){
				// Note that we don't have ads on the search page right now, so this isn't going to do any good
				$out .= 'GA_googleAddAdSensePageAttr("google_hints", "' . addslashes($_GET['search']) . '";';
			} else {
				// Pull in the same keywords we use for the page.
				$out .= 'GA_googleAddAdSensePageAttr("google_hints", AdEngine.getKeywords());';
			}
			break;
		  case '2695313814':
			$out .= 'GA_googleAddAdSensePageAttr("google_page_url", "' . addslashes(AdProviderGoogle::getPageUrl()) . '");' . "\n";
			break;

		  case '1561126031':
			$out .= 'GA_googleAddAdSensePageAttr("google_language", wgUserLanguage);' . "\n";
			break;

		  case '1816018796':
			$out .= 'GA_googleAddAdSensePageAttr("google_language", wgContentLanguage);' . "\n";
			break;

		  case '4120043396':
			if(!empty($_GET['search'])){
				// Note that we don't have ads on the search page right now, so this isn't going to do any good
				$out .= 'GA_googleAddAdSensePageAttr("google_kw", "' . addslashes($_GET['search']) . '";';
			} else {
				// Pull in the same keywords we use for the page.
				$out .= 'GA_googleAddAdSensePageAttr("google_kw", AdEngine.getKeywords());';
			}
			break;

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
		if (! $this->batchHtmlCalled){
			$out .= $this->getBatchCallHtml();
		} 

		return $out . '<script type="text/javascript">GA_googleFillSlot("' . $slotname . '")</script>';
	}


	private function getHub(){
		$cat=AdEngine::getCachedCategory();
		if(!empty($cat['name'])) {
			if(!empty($this->sites[$cat['name']])) {
				return $this->sites[$cat['name']];
			}
		}
		return 'wikia';
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

