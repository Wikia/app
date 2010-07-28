<?php

require_once dirname(__FILE__) . '/ArticleAdLogic.php';

$wgExtensionCredits['other'][] = array(
	'name' => 'AdEngine',
	'author' => 'Inez Korczynski, Nick Sullivan'
);

$wgHooks['BeforePageDisplay'][] = 'adEngineAdditionalScripts';
$wgHooks["MakeGlobalVariablesScript"][] = "wfAdEngineSetupJSVars";
function wfAdEngineSetupJSVars($vars) {
	global $wgEnableAdsInContent;

	$vars["wgEnableAdsInContent"] = $wgEnableAdsInContent;

	return true;
}

/**
 * Before the page is rendered this gives us a chance to cram some Javascript in.
 */
function adEngineAdditionalScripts( &$out, &$sk ){
	global $wgExtensionsPath,$wgStyleVersion;

	$out->addScript("<script type='text/javascript' src='$wgExtensionsPath/wikia/AdEngine/LazyLoadAds.js?$wgStyleVersion'></script>\n");
	return true;
} // end adEngineAdditionalScripts()

$wgHooks["WikiFactoryChanged"][] = "AdEngine::clearSlotCache";

interface iAdProvider {
	public static function getInstance();
	public function getAd($slotname, $slot);
	public function batchCallAllowed();
	public function addSlotToCall($slotname);
	public function getSetupHtml();
	public function getBatchCallHtml();
}

abstract class AdProviderIframeFiller {
        public function getIframeFillHtml($slotname, $slot) {
                global $wgEnableAdsLazyLoad, $wgAdslotsLazyLoad;

                $function_name = AdEngine::fillIframeFunctionPrefix . $slotname;
                $out = $this->getIframeFillFunctionDefinition($function_name, $slotname, $slot);
                if (!$wgEnableAdsLazyLoad || empty($wgAdslotsLazyLoad[$slotname])) {
                    $out .= "\n".'<script type="text/javascript">' . "$function_name();" . '</script>';
                }

                return $out;
        }

        abstract protected function getIframeFillFunctionDefinition($function_name, $slotname, $slot);

}

class AdEngine {

	const cacheKeyVersion = "2.01a";
	const cacheTimeout = 1800;
        const lazyLoadAdClass = 'LazyLoadAd';
        const fillIframeFunctionPrefix = 'fillIframe_';

	// TODO: pull these from wikicities.provider
	private $providers = array(
		'1' => 'DART',
		'2' => 'OpenX',
		'3' => 'Google',
		'4' => 'GAM',
		'5' => 'PubMatic',
		'6' => 'Athena',
		'7' => 'ContextWeb',
		'8' => 'DARTMobile',
		'9' => 'Liftium',
		'-1' => 'Null'
	);

	private $slots = array();

	private $placeholders = array();

	private $loadType = 'delayed';

	protected static $instance = false;

	// Exclude these $wgDBname's from bucket testing
	private $handsOffWikis = array(
		'masseffect',
		'warhammeronline',
		'starcraft',
		'diablo',
		'blind'
	);

	protected function __construct($slots = null) {
		if (!empty($slots)){
			$this->slots=$slots;
		} else {
			$this->loadConfig();
		}
		if (isset($_GET['athena_debug'])){
			echo "<!-- Ad Slot settings:" . print_r($this->slots, true) . "-->";
		}
		global $wgAutoloadClasses;
		foreach($this->providers as $p) {
			$wgAutoloadClasses['AdProvider' . $p]=dirname(__FILE__) . '/AdProvider'.$p.'.php';
		}

		global $wgRequest,$wgNoExternals,$wgShowAds;
		$wgNoExternals = $wgRequest->getBool('noexternals', $wgNoExternals);
		if(!empty($wgNoExternals)){
			$wgShowAds = false;
		}
	}

	public static function getInstance($slots = null) {
		if(self::$instance == false) {
			self::$instance = new AdEngine($slots);
		}
		return self::$instance;
	}

	// Load up all the providers. For each one, set up

	public function getSetupHtml(){

		$out = "<!-- #### BEGIN " . __CLASS__ . '::' . __METHOD__ . " ####-->\n";

		// If loading the ads inline, call the set up html for each provider.
		// If loading delayed, this is done in getDelayedAdLoading method instead.
		if ($this->loadType == 'inline'){
			// for loadType set to inline we have to load AdEngine.js here
			// for loadType set to delayed AdEngine.js should be inside of allinone.js
			global $wgExtensionsPath, $wgEnableAdsLazyLoad, $wgAdslotsLazyLoad;
			$out .= '<script type="text/javascript" src="' . $wgExtensionsPath . '/wikia/AdEngine/AdEngine.js?' . self::cacheKeyVersion . '"></script>'. "\n";
                        if ($wgEnableAdsLazyLoad && sizeof($wgAdslotsLazyLoad)) {
                            $out .= '<script type="text/javascript" src="' . $wgExtensionsPath . '/wikia/AdEngine/LazyLoadAds.js?' . self::cacheKeyVersion . '"></script>'. "\n";
                        }

			foreach($this->slots as $slotname => $slot) {
                        	$AdProvider = $this->getAdProvider($slotname);
                        	// Get setup HTML for each provider. May be empty.
                        	$out .= $AdProvider->getSetupHtml();
                        }
		}

		$out .= "<!-- #### END " . __CLASS__ . '::' . __METHOD__ . " ####-->\n";

		return $out;
	}

	public static function clearSlotCache($cv_name , $city_id, $value) {
		if (!preg_match("/^wgAdslot/", $cv_name)) return true;

		global $wgMemc;
		$cacheKey = wfForeignMemcKey(WikiFactory::IDtoDB($city_id), false, __CLASS__ . 'slots', 'monaco', AdEngine::cacheKeyVersion);
		$wgMemc->delete($cacheKey);

		return true;
	}

	public function loadConfig() {
		global $wgShowAds;
		if( empty( $wgShowAds ) ) {
			$this->slots = array();
			return true;
		}

		global $wgMemc, $wgCityId, $wgUser, $wgRequest, $wgExternalSharedDB, $wgDBname;

		$skin_name = null;
		if ( is_object($wgUser)){
				$skin_name = $wgUser->getSkin()->getSkinName();
		}

		// sometimes no skin set yet; hack copied from Interstitial::getCss
		if (empty($skin_name)) $skin_name = substr(get_class($wgUser->getSkin()), 4);

		if ($skin_name == 'awesome' || $skin_name == 'answers' ){
			// Temporary hack while we transition to lean monaco
			$skin_name = 'monaco';
		} else if ($wgDBname == "wikiaglobal"){
			// Hack for www
			$skin_name = 'corporate';
		}

		$cacheKey = wfMemcKey(__CLASS__ . 'slots', $skin_name, self::cacheKeyVersion);
		$this->slots = $wgMemc->get($cacheKey);

		if(is_array($this->slots) && $wgRequest->getVal('action') != 'purge') {
			// Found a cached value
			return true;
		}

		$db = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$ad_slot_table = 'ad_slot';
		$ad_slot_override_table = 'ad_slot_override';
		$ad_provider_value_table = 'ad_provider_value';

		$sql = "SELECT ad_slot.as_id, ad_slot.slot, ad_slot.size, ad_slot.load_priority,
				COALESCE(adso.provider_id, ad_slot.default_provider_id) AS provider_id,
				COALESCE(adso.enabled, ad_slot.default_enabled) AS enabled
				FROM $ad_slot_table
				LEFT OUTER JOIN $ad_slot_override_table AS adso
				  ON ad_slot.as_id = adso.as_id AND city_id=".intval($wgCityId)."
				WHERE skin='".$db->strencode($skin_name)."'";

		$res = $db->query($sql);
		$this->slots = array();

		while($row = $db->fetchObject($res)){
			$this->slots[$row->slot] = array(
				'as_id' => $row->as_id,
				'size' => $row->size,
				'provider_id' => $row->provider_id,
				'provider' => $this->providers[$row->provider_id],	 // information only
				'enabled' => $row->enabled,
				'load_priority' => $row->load_priority
			);
		}

		$sql = "SELECT * FROM $ad_provider_value_table WHERE
			 (city_id = ".intval($wgCityId)." OR city_id IS NULL) ORDER by city_id";
		$res = $db->query($sql);
		while($row = $db->fetchObject($res)) {
			 foreach($this->slots as $slotname => $slot) {
			 	if($slot['provider_id'] == $row->provider_id){
					$this->slots[$slotname]['provider_values'][] = array('keyname' => $row->keyname, 'keyvalue' => $row->keyvalue);
			 	}
			 }
		}
		$this->applyWikiOverrides();
		$wgMemc->set($cacheKey, $this->slots, self::cacheTimeout);

		return true;
	}


	function getProviderid($provider){
		foreach($this->providers as $id => $p) {
			if (strtolower($provider) == strtolower($p) ){
				return $id;
			}
		}
		return false;
	}


	/* Allow Wiki Factory variables to override what is in the slots */
	function applyWikiOverrides(){
		foreach($this->slots as $slotname => $slot) {
			$name = 'wgAdslot_' . $slotname;
			if (!empty($GLOBALS[$name])){
				$provider_id = $this->getProviderid($GLOBALS[$name]);
				if ($provider_id === false ){
					trigger_error("Invalid value for $name ({$GLOBALS[$name]})", E_USER_WARNING);
					continue;
				}
				$this->slots[$slotname]['provider_id'] = $provider_id;
				$this->slots[$slotname]['provider'] = $GLOBALS[$name];
				$this->slots[$slotname]['overridden_by'] = $name;
				$this->slots[$slotname]['enabled'] = "Yes";
			}
		}
	}


	/* Simple accessor for slots array */
	public function getSlots() {
		return $this->slots;
	}


	/* Category name/id is needed multiple times for multiple providers. Be gentle on our dbs by adding a thin caching layer. */
	public function getCachedCategory(){
		static $cat;
		if (! empty($cat)){
			// This function already called
			return $cat;
		}

		if (!empty($_GET['forceCategory'])){
			// Passed in through the url, or hard coded on a test_page. ;-)
			return $_GET['forceCategory'];
		}

		global $wgMemc, $wgCityId, $wgRequest;
		$cacheKey = wfMemcKey(__CLASS__ . 'category', self::cacheKeyVersion);

		$cat = $wgMemc->get($cacheKey);
		if (!empty($cat) && $wgRequest->getVal('action') != 'purge'){
			return $cat;
		}

		$hub = WikiFactoryHub::getInstance();
		$cat = array(
			'id'=>$hub->getCategoryId($wgCityId),
			'name'=>$hub->getCategoryName($wgCityId),
			'short'=>$hub->getCategoryShort($wgCityId),
		);

		$wgMemc->set($cacheKey, $cat, self::cacheTimeout);
		return $cat;
	}

	// For the provided $slotname, get an ad tag.
	public function getAd($slotname) {
		$AdProvider = $this->getAdProvider($slotname);
		return $AdProvider->getAd($slotname, empty($this->slots[$slotname]) ? array() : $this->slots[$slotname]);
	}

	// Logic for hiding/displaying ads should be here, not in the skin.
	private function getAdProvider($slotname) {
		global $wgShowAds, $wgUser, $wgLanguageCode, $wgNoExternals;


		/* Note: Don't throw an exception on error. Fail gracefully for ads,
		 * don't under any circumstances fail the rendering of the page.
		 * Instead, return a "AdProviderNull" object with an error message.
		 * Note that the second parameter for AdProviderNull constructor
		 * is a boolean for whether or not to log it as an error
		 */

		// First handle error conditions
		if (!empty($wgNoExternals)){
			return new AdProviderNull('Externals (including ads) are not allowed right now.');
		
		} else if (empty($this->slots[$slotname])) {
			return new AdProviderNull('Unrecognized slot', false);

		} else if ($this->slots[$slotname]['enabled'] == 'No'){
			return new AdProviderNull("Slot is disabled", false);

		// As long as they are enabled via config, spotlights are always displayed...
		} else if ( AdEngine::getInstance()->getAdType($slotname) == 'spotlight' ){
			return $this->getProviderFromId($this->slots[$slotname]['provider_id']);

		// Now some toggles based on preferences and logged in/out
		} else if (! ArticleAdLogic::isMandatoryAd($slotname) &&
			     empty($_GET['showads']) && $wgShowAds == false ){
			return new AdProviderNull('$wgShowAds set to false', false);

		} else if (! ArticleAdLogic::isMandatoryAd($slotname) && empty($_GET['showads']) &&
			   is_object($wgUser) && $wgUser->isLoggedIn() && !$wgUser->getOption('showAds') ){
			return new AdProviderNull('User is logged in', false);

		} else if (!empty($_GET['forceProviderid'])){
			// For debugging, allow ad providers to be forced
			return $this->getProviderFromId($_GET['forceProviderid']);

		// Special case for this type of ad. Not in Athena
		} else if ($slotname == 'RIGHT_SKYSCRAPER_1'){
			return $this->getProviderFromId($this->slots[$slotname]['provider_id']);

		// All of the errors and toggles are handled, now switch based on language
		} else {

			if (! in_array($wgLanguageCode, AdProviderGoogle::getSupportedLanguages())){
				// Google's TOS prevents serving ads for some languages
				return new AdProviderNull("Unsupported language for Google Adsense ($wgLanguageCode)", false);
			} else {
			 	return $this->getProviderFromId($this->slots[$slotname]['provider_id']);
			}
		}

		// Should never happen, but be sure that an AdProvider object is always returned.
		return new AdProviderNull('Logic error in ' . __METHOD__, true);
	}


	public function getProviderFromId ($provider_id) {
		switch (strtolower($this->providers[$provider_id])){
			case 'dart': return AdProviderDART::getInstance();
			case 'openx': return AdProviderOpenX::getInstance();
			case 'google': return AdProviderGoogle::getInstance();
			case 'gam': return AdProviderGAM::getInstance();
			case 'pubmatic': return AdProviderPubMatic::getInstance();
			case 'athena': return AdProviderAthena::getInstance();
			case 'contextweb': return AdProviderContextWeb::getInstance();
			case 'dartmobile': return AdProviderDARTMobile::getInstance();
			case 'liftium': return AdProviderLiftium::getInstance();
			case 'null': return new AdProviderNull('Slot disabled in WF', false);
			default: return new AdProviderNull('Unrecognized provider id', true);
		}
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

	public function getPlaceHolderIframe($slotname, $reserveSpace=true){
                global $wgEnableAdsLazyLoad, $wgAdslotsLazyLoad;
                
		$html = null;
		wfRunHooks("fillInAdPlaceholder", array("iframe", $slotname, &$this, &$html));
		if (!empty($html)) return $html;

		$AdProvider = $this->getAdProvider($slotname);
		// If it's a Null Ad, just return an empty comment, and don't store in place holder array.
		if ($AdProvider instanceof AdProviderNull){
			return "<!-- Null Ad from " . __METHOD__ . "-->" . $AdProvider->getAd($slotname, array()); 
		}

		$this->placeholders[$slotname]=$this->slots[$slotname]['load_priority'];

		if ($reserveSpace) {
			$dim = self::getHeightWidthFromSize($this->slots[$slotname]['size']);
			$h = $dim['height'];
			$w = $dim['width'];
		} else {
			$h = 0;
			$w = 0;
		}

		// Make the 300x250 on the home page a 300x600
		global $wgEnableHome300x600;
		if ($slotname == "HOME_TOP_RIGHT_BOXAD" && $wgEnableHome300x600){
			$h = 300;	
			$h = 600;	
		}

		// Make the 300x250 on the article pages a 300x600
		global $wgEnableArticle300x600;
		if ($slotname == "TOP_RIGHT_BOXAD" && $wgEnableArticle300x600){
			$w = 300;
			$h = 600;
		}

		static $adnum = 0;
		$adnum++;
		if ($AdProvider instanceof AdProviderLiftium){
			$slotdiv = "Liftium_" . $this->slots[$slotname]['size'] . "_" . $adnum . "_php"; 
		} else {
			$slotdiv = "Wikia_" . $this->slots[$slotname]['size'] . "_" . $adnum; 
		}

                $slotiframe_class = '';
                if ($wgEnableAdsLazyLoad) {
                    if (!empty($wgAdslotsLazyLoad[$slotname])) {
                        $slotiframe_class = self::lazyLoadAdClass;
                    }
                }
	
		return '<div id="' . htmlspecialchars($slotname) . '" class="noprint">' . 
			'<div id="' . htmlspecialchars($slotdiv) . '">' .
			'<iframe width="' . intval($w) . '" height="' . intval($h) . '" ' . 
			'id="' . htmlspecialchars($slotname) . '_iframe" class="' . $slotiframe_class . '" ' .
                	'noresize="true" scrolling="no" frameborder="0" marginheight="0" ' . 
			'marginwidth="0" style="border:none" target="_blank"></iframe></div></div>';
	}

	/* For delayed ad loading, we have a place holder div that gets placed in the content,
	   to be loaded at the bottom of the page with an absolute position.
	   Keep track fo the placeholders for future refence */
	public function getPlaceHolderDiv($slotname, $reserveSpace=true){
		$html = null;
		wfRunHooks("fillInAdPlaceholder", array("div", $slotname, &$this, &$html));
		if (!empty($html)) return $html;

		$AdProvider = $this->getAdProvider($slotname);
		// If it's a Null Ad, just return an empty comment, and don't store in place holder array.
		if ($AdProvider instanceof AdProviderNull){
			return "<div id=\"$slotname\" style=\"display:none\">" . $AdProvider->getAd($slotname, array()) . "</div>";
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

		$style = ' style="'. implode(" ", $styles) .'" class="wikia_ad_placeholder"';

		// We will use these at the bottom of the page for ads, if delayed ad loading is enabled
		$this->placeholders[$slotname]=$this->slots[$slotname]['load_priority'];

		// Fill in slotsToCall with a list of slotnames that will be used. Needed for getBatchCallHtml
		$AdProvider->addSlotToCall($slotname);

		return "<div id=\"$slotname\"$style></div>";
	}

	public function getDelayedLoadingCode(){
		global $wgExtensionsPath;

		if (empty($this->placeholders)){
			// No delayed ads on this page
			return '<!-- No placeholders called for ' . __METHOD__ . " -->\n";
		}

		// Sort by load_priority
		asort($this->placeholders);
		$this->placeholders = array_reverse($this->placeholders);

		$out = "<!-- #### BEGIN " . __CLASS__ . '::' . __METHOD__ . " ####-->\n";

		global $wgCityId;
		$out .=  $this->providerValuesAsJavascript($wgCityId);

		// Get the setup code for ad providers used on this page. This is for Ad Providers that support multi-call.
		foreach ($this->placeholders as $slotname => $load_priority){
	                $AdProvider = $this->getAdProvider($slotname);

			// Get setup HTML for each provider. May be empty.
			$out .= $AdProvider->getSetupHtml();
		}

		foreach ($this->placeholders as $slotname => $load_priority){
			$AdProvider = $this->getAdProvider($slotname);

			// Hmm. Should we just use: class="wikia_$adtype"?
			$class = self::getAdType($slotname) == 'spotlight' ? ' class="wikia_spotlight"' : ' class="wikia_ad"';
			// This may be better, but needs more testing. $out .= '<div id="' . $slotname . '_load"' . $class . '>' . $AdProvider->getAd($slotname, $this->slots[$slotname]) . "</div>\n";
                        $out .= '<div id="' . $slotname . '_load" style="display: none; position: absolute;"'.$class.'>' . $AdProvider->getAd($slotname, $this->slots[$slotname]) . "</div>\n";


			/* This image is what will be returned if there is NO AD to be displayed.
 			 * If this happens, we want leave the div collapsed.
			 * We tried for a more elegant solution, but were a bit constrained on the
			 * code that could be returned from the ad networks we deal with.
			 * I'd like to see a better solution for this, someday
			 * See Christian or Nick for more info.
			*/
			$out .= '<script type="text/javascript">' .
				'AdEngine.displaySlotIfAd("'. addslashes($slotname) .'");' .
				'</script>' . "\n";
		}
		$out .= "<!-- #### END " . __CLASS__ . '::' . __METHOD__ . " ####-->\n";
		return $out;
	}


	public function getDelayedIframeLoadingCode(){
		global $wgExtensionsPath, $wgEnableAdsLazyLoad;

		if (empty($this->placeholders)){
			// No delayed ads on this page
			return '<!-- No iframe placeholders called for ' . __METHOD__ . " -->\n";
		}

		// Sort by load_priority
		asort($this->placeholders);
		$this->placeholders = array_reverse($this->placeholders);

		$out = "<!-- #### BEGIN " . __CLASS__ . '::' . __METHOD__ . " ####-->\n";

		global $wgCityId;
		$out .=  $this->providerValuesAsJavascript($wgCityId);

		// Get the setup code for ad providers used on this page. This is for Ad Providers that support multi-call.
		foreach ($this->placeholders as $slotname => $load_priority){
	                $AdProvider = $this->getAdProvider($slotname);

			// Get setup HTML for each provider. May be empty.
			$out .= $AdProvider->getSetupHtml();
		}

		// Call the code to set the iframe urls for the iframes
                foreach ($this->placeholders as $slotname => $load_priority){
	                $AdProvider = $this->getAdProvider($slotname);
			// Currently only supported by GAM and Athena
			if (method_exists($AdProvider, "getIframeFillHtml")){
                        	$out .= $AdProvider->getIframeFillHtml($slotname, $this->slots[$slotname]);
			} 
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
			case '125x125': return 'spotlight';
			case '728x90': return 'leaderboard';
			case '300x250': return 'boxad';
			case '160x600': return 'skyscraper';
			case '120x600': return 'skyscraper';
			case '200x200': return 'navbox';
			case '0x0': return 'invisible';
			default: return NULL;
		}
	}


	/* Either 'delayed' or 'inline' */
	public function setLoadType($loadType){
		$this->loadType = $loadType;
		if ($loadType == 'inline'){
			// Fill in slotsToCall with a list of slotnames that will be used. Needed for getBatchCallHtml
			foreach($this->slots as $slotname => $slot) {
				$AdProvider = $this->getAdProvider($slotname);
				$AdProvider->addSlotToCall($slotname);
			}
		}
	}


	/* Odd request that I didn't have a better way to handle. Michael wanted the DART
	 * Key value string as a javascript variable.
	 */
	public function providerValuesAsJavascript($city_id){
		global $wgMemc, $wgRequest, $wgExternalSharedDB;
		$cacheKey = wfMemcKey(__CLASS__ . 'dartkeyvalues', self::cacheKeyVersion);

		$out = $wgMemc->get($cacheKey);
		if (!empty($out) &&  $wgRequest->getVal('action') != 'purge'){
			return $out;
		}

		$db = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$ad_provider_value_table = 'ad_provider_value';

		$sql = "SELECT * FROM $ad_provider_value_table WHERE city_id = ".intval($city_id);
		$res = $db->query($sql);

		$list = array();
		$string = '';
		while($row = $db->fetchObject($res)) {
			$list[]= array('name'=> $row->keyname, 'value'=>$row->keyvalue);
			$string .= $row->keyname . '=' . urlencode($row->keyvalue) . ';';
		}

		$out =  '<script type="text/javascript">' . "\n" .
			'ProviderValues = {};' . "\n" .
			'ProviderValues.list = ' . json_encode($list) . ";\n" .
			'ProviderValues.string = "' . $string . '"' . ";\n" .
			'</script>';

		$wgMemc->set($cacheKey, $out, self::cacheTimeout);

		return $out;
	}


	public function getSlotNamesForProvider($provider_id){
		$out = array();
		foreach($this->slots as $slotname => $data ){
			if ($data['enabled'] == 'Yes' && $data['provider_id'] == $provider_id){
				$out [] = $slotname;
			}
		}
		return $out;
	}

}
