<?php

require_once dirname(__FILE__) . '/ArticleAdLogic.php';

$wgExtensionCredits['other'][] = array(
	'name' => 'AdEngine',
	'author' => 'Inez Korczynski, Nick Sullivan'
);

interface iAdProvider {
	public static function getInstance();
	public function getAd($slotname, $slot);
}

class AdEngine {

	const cacheKeyVersion = "1.9a";
	const cacheTimeout = 1800;
	const noadgif = "http://images2.wikia.nocookie.net/common/wikia/noad.gif";

	// TODO: pull these from wikicities.provider
	private $providers = array('1' => 'DART', '2' => 'OpenX', '3' => 'Google', '-1' => 'Null');

	private $slots = array();

	private $placeholders = array();

	protected static $instance = false;

	protected function __construct() {
		$this->loadConfig();
		global $wgAutoloadClasses;
		foreach($this->providers as $p) {
			$wgAutoloadClasses['AdProvider' . $p]=dirname(__FILE__) . '/AdProvider'.$p.'.php';
		}
	}

	public static function getInstance() {
		if(self::$instance == false) {
			self::$instance = new AdEngine();
		}
		return self::$instance;
	}

	public function loadConfig() {
		$skin_name = 'monaco'; // Hard code for now.
		global $wgMemc, $wgCityId;

		$cacheKey = wfMemcKey(__CLASS__ . 'slots', $skin_name, self::cacheKeyVersion);
		$this->slots = $wgMemc->get($cacheKey);

		if(is_array($this->slots)){
			// Found a cached value
			return true;
		}

		$db = wfGetDB(DB_SLAVE);

		$sql = "SELECT ad_slot.as_id, ad_slot.slot, ad_slot.size,
				COALESCE(adso.provider_id, ad_slot.default_provider_id) AS provider_id,
				COALESCE(adso.enabled, ad_slot.default_enabled) AS enabled
				FROM wikicities.ad_slot
				LEFT OUTER JOIN wikicities.ad_slot_override AS adso
				  ON ad_slot.as_id = adso.as_id AND city_id=".intval($wgCityId)."
				WHERE skin='".$db->strencode($skin_name)."'";

		$res = $db->query($sql);

		while($row = $db->fetchObject($res)){
			$this->slots[$row->slot] = array(
				'as_id' => $row->as_id,
				'size' => $row->size,
				'provider_id' => $row->provider_id,
				'enabled' => $row->enabled
			);
		}

		$sql = "SELECT * FROM wikicities.ad_provider_value WHERE
			 (city_id = ".intval($wgCityId)." OR city_id IS NULL) ORDER by city_id";
		$res = $db->query($sql);
		while($row = $db->fetchObject($res)) {
			 foreach($this->slots as $slotname => $slot) {
			 	if($slot['provider_id'] == $row->provider_id){
					$this->slots[$slotname]['provider_values'][$row->keyname] = $row->keyvalue;
			 	}
			 }
		}
		$wgMemc->set($cacheKey, $this->slots, self::cacheTimeout);

		return true;
	}


	/* Category name/id is needed multiple times for multiple providers. Be gentle on our dbs by adding a thin caching layer. */
	public function getCachedCategory(){
		static $cat;
		if (! empty($cat)){
			// This function already called
			return $cat;
		}

		global $wgMemc, $wgCityId;
		$cacheKey = wfMemcKey(__CLASS__ . 'category', self::cacheKeyVersion);

		$cat = $wgMemc->get($cacheKey);
		if (!empty($cat)){
			return $cat;
		}

		$hub = WikiFactoryHub::getInstance();
		$cat = array(
			'id'=>$hub->getCategoryId($wgCityId),
			'name'=>$hub->getCategoryName($wgCityId)
		);

		$wgMemc->set($cacheKey, $cat, self::cacheTimeout);
		return $cat;
	}

	// For the provided $slotname, get an ad tag. 
	public function getAd($slotname) {

		$AdProvider = $this->getAdProvider($slotname);
		return $AdProvider->getAd($slotname, $this->slots[$slotname]);

	}
	
	// Logic for hiding/displaying ads should be here, not in the skin.
	private function getAdProvider($slotname) {
		global $wgShowAds, $wgUser, $wgLanguageCode;


		// Note: Don't throw an exception on error. Fail gracefully for ads,
		// don't under any circumstances fail the rendering of the page.
		// Instead, return a "AdProviderNull" object with an error message

		if (empty($this->slots[$slotname])) {
			return new AdProviderNull('Unrecognized slot', true);

		} else if ($this->slots[$slotname]['enabled'] == 'No'){
			return new AdProviderNull("Slot is disabled", false);

		} else if (! ArticleAdLogic::isMandatoryAd($slotname) &&
			     empty($_GET['showads']) && $wgShowAds == false ){
			return new AdProviderNull('$wgShowAds set to false', false);

		} else if (! ArticleAdLogic::isMandatoryAd($slotname) && empty($_GET['showads']) && 
			   is_object($wgUser) && $wgUser->isLoggedIn() && !$wgUser->getOption('showAds') ){
			return new AdProviderNull('User is logged in', false);

 	        } else if (empty($this->providers[$this->slots[$slotname]['provider_id']])) {

			return new AdProviderNull('Unrecognized provider', true);
 	        } else if ($wgLanguageCode != 'en' ){
			// Different settings for non english wikis.
			if ( AdEngine::getInstance()->getAdType($slotname) == 'spotlight' ){
				return AdProviderOpenX::getInstance();
			} else {
				return new AdProviderNull('Non English wiki', false);
			}
		} else {
			
			// Error conditions out of the way, send back the appropriate Ad provider
			switch ($this->providers[$this->slots[$slotname]['provider_id']]){
				case 'DART': return AdProviderDART::getInstance();
				case 'OpenX': return AdProviderOpenX::getInstance();
				case 'Google': return AdProviderGoogle::getInstance();
			}
		}

		// Should never happen, but be sure that an object is always returned.
		return new AdProviderNull('Logic error in ' . __METHOD__, true);
	}

	/* Size is stored as $widthx$size character column. Split here.
 	 * You may be asking, why not just store it as separate values to be begin with?
 	 * Because size is not always height/width. Possible values for size include:
 	 * 728x60
 	 * 300x250,300x600
 	 * 728x*
 	 *
 	 * Do the best you can to return a height/width
 	 */
        public function getHeightWidthFromSize($size){
                if (preg_match('/^([0-9]{2,4})x([0-9]{2,4})/', $size, $matches)){
                        return array('width'=>$matches[1], 'height'=>$matches[2]);
                } else if (preg_match('/^([0-9]{2,4})x\*/', $size, $matches)){
                        return array('width'=>$matches[1], 'height'=>'*');
                } else {
                        return false;
                }
        }


	/* For delayed ad loading, we have a place holder div that gets placed in the content,
	   to be loaded at the bottom of the page with an absolute position.
	   Keep track fo the placeholders for future refence */
	public function getPlaceHolderDiv($slotname, $reserveSpace=true){
		$AdProvider = $this->getAdProvider($slotname);
		// If it's a Null Ad, just return an empty comment, and don't store in place holder array.
		if ($AdProvider instanceof AdProviderNull){
			return "<div id=\"$slotname\" style=\"display:none\">'" . $AdProvider->getAd($slotname, array()) . "</div>";
		}

		$styles = array();
		$dim = self::getHeightWidthFromSize($this->slots[$slotname]['size']);
		if (!empty($dim['width'])){
			array_push($styles, "width: {$dim['width']}px;");
			array_push($styles, "height: {$dim['height']}px;");
		}

		if($this->slots[$slotname]['enabled'] == 'No' || $reserveSpace == false){
			array_push($styles, "display: none;");
		}

		$style = ' style="'. implode(" ", $styles) .'"';

		// We will use this at the bottom of the page for ads.
		$this->placeholders[] = $slotname;

		return "<div id=\"$slotname\"$style></div>";
	}


	public function getDelayedLoadingCode(){
		global $wgExtensionsPath;

		if (empty($this->placeholders)){
			// No delayed ads on this page
			return '<!-- No placeholders called for ' . __METHOD__ . " -->\n";
		}

		$out = "<!-- #### BEGIN " . __CLASS__ . '::' . __METHOD__ . " ####-->\n";
		$out .= '<script type="text/javascript">TieDivLibrary.timer();</script>' . "\n";
		foreach ($this->placeholders as $slotname){
			$AdProvider = $this->getAdProvider($slotname);

			// Hmm. Should we just use: class="wikia_$adtype"?
			$class = self::getAdType($slotname) == 'spotlight' ? ' class="wikia_spotlight"' : ' class="wikia_ad"';
			$out .= '<div id="' . $slotname . '_load"'.$class.'>' . $AdProvider->getAd($slotname, $this->slots[$slotname]) . "</div>\n";

			/* This image is what will be returned if there is NO AD to be displayed.
 			 * If this happens, we want leave the div collapsed.
			 * We tried for a more elegant solution, but were a bit constrained on the
			 * code that could be returned from the ad networks we deal with.
			 * I'd like to see a better solution for this, someday
			 * See Christian or Nick for more info.
			*/
			$out .= '<script type="text/javascript">
				// expand the div, as long as there is an ad returned.
				if($("'.$slotname.'_load").innerHTML.indexOf("' . self::noadgif . '") == -1) {
					YAHOO.util.Dom.setStyle("'. $slotname .'", "display", "block");
				}
	
				// Absolutely position the ${slotname}_load div over the top of the placeholder
				TieDivLibrary.tie("'. $slotname .'");
				</script>' . "\n";
		}
		$out .= "<!-- #### END " . __CLASS__ . '::' . __METHOD__ . " ####-->\n";
		return $out;
	}

	public function getPlaceHolders(){
		return $this->placeholders;
	}


        /* Sometimes there is different behavior for different types of ad. Reduce the number of
         * hacks and hard coded slot names by providing a grouping on type of based on size.
         * Possible return values:
         *  "spotlight" , "leaderboard", "boxad", "skyscraper"
         *
         * NULL will be returned if this function is unable to determine the type of ad
         *
	 * Long term, this should be a column in the ad_slots table. This will happen when
	 * we build the UI for managing those tables.
         */
        public function getAdType($slotname){
                if (empty($this->slots[$slotname]['size'])){
                        return NULL;
                }  

		switch ($this->slots[$slotname]['size']){
			case '200x75': return 'spotlight';
			case '728x90': return 'leaderboard';
			case '300x250': return 'boxad';
			case '160x600': return 'skyscraper';
			default: return NULL;
		}
        }

}
