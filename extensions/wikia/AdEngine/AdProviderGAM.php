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

		// Always pass the hub as a key value
		$out .= $this->getTargetingValue('hub', $this->getHub()) . "\n";
		// And languages
		$out .= 'GA_googleAddAttr("cont_lang", wgContentLanguage);' . "\n";
		$out .= 'GA_googleAddAttr("user_lang", wgUserLanguage);' . "\n";
		$out .= '</script>' . "\n";
		
		// Make the call for all the ads
		$out .= '<script type="text/javascript">GA_googleFetchAds()</script>' . "\n";
		

		$out .= "<!-- ## END " . __CLASS__ . '::' . __METHOD__ . " ## -->\n";
		return $out;	
	}


	public function getAd($slotname, $slot){
		$out = "";
		// First time the ad is called, call all the batch code, if it hasn't already been called.
		if (! $this->batchHtmlCalled){
			$out .= $this->getBatchCallHtml();
		} 

		return $out .'<script type="text/javascript">GA_googleFillSlot("' . $slotname . '")</script>';
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
		if(empty($slot['provider_values'])){
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
