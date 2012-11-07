<?php

require_once dirname(__FILE__) . '/PartnerWidget.php';

$wgExtensionCredits['other'][] = array(
	'name' => 'AdEngine',
	'author' => 'Inez Korczynski, Nick Sullivan'
);

$wgHooks['MakeGlobalVariablesScript'][] = 'wfAdEngineSetupJSVars';
$wgHooks['WikiaSkinTopScripts'][] = 'wfAdEngineSetupTopVars';
$wgExtensionFunctions[] = 'wfAdEngineInit';

function wfAdEngineInit() {
	global $wgRequest, $wgUser;
	global $wgNoExternals, $wgShowAds, $wgEnableAdsInContent, $wgEnableAdMeldAPIClient, $wgEnableKruxTargeting, $wgLoadAdsInHead;

	// No ads when noexternals or noads is passed in URL
	if ($wgRequest->getBool('noexternals', $wgNoExternals) || $wgRequest->getBool('noads', false)) {
		$wgShowAds = false;
	}

	if (WikiaPageType::isActionPage()) {
		$wgShowAds = false;
	}

	if (empty($wgShowAds)) {
		$wgEnableAdsInContent = false;
		$wgEnableAdMeldAPIClient = false;
		$wgEnableKruxTargeting = false;
	}

	if ($wgUser->isLoggedIn() && !$wgUser->getOption('showAds')) {
		// Disable right rail ads and AdMeld ads for logged in users not willing to see ads
		$wgEnableAdsInContent = false;
		$wgEnableAdMeldAPIClient = false;
	}

	// Canonical value for wgLoadAdsInHead
	$wgLoadAdsInHead = !empty($wgLoadAdsInHead);

	// Override wgLoadAdsInHead by cookie adsinhead
	$wgLoadAdsInHead = (bool) $wgRequest->getCookie('adsinhead', '', $wgLoadAdsInHead);

	// Override wgLoadAdsInHead by URL param adsinhead (?adsinhead=0 or ?adsinhead=1)
	$wgLoadAdsInHead = $wgRequest->getBool('adsinhead', $wgLoadAdsInHead);
}

//$wgHooks["WikiaSkinTopScripts"][] = "wfAdEngineSetupJSVars";
//$wgHooks['WikiaSkinTopScripts'][] = 'wfAdEngineSetupTopVars';

function wfAdEngineSetupTopVars(&$vars) {
	global $wgCityId, $wgEnableKruxTargeting, $wgNoExternals;

	wfProfileIn(__METHOD__);

	// generic type of page: forum/search/article/home/...
	$vars['wikiaPageType'] = WikiaPageType::getPageType();

	// category/hub
	$catInfo = HubService::getComscoreCategory($wgCityId);
	$vars['cscoreCat'] = $catInfo->cat_name;

	// Krux
	$cat = AdEngine::getCachedCategory();
	if (!empty($wgEnableKruxTargeting) && empty($wgNoExternals)) {
		$vars['wgEnableKruxTargeting'] = $wgEnableKruxTargeting;
		$vars['wgKruxCategoryId'] = WikiFactoryHub::getInstance()->getKruxId($cat['id']);
	}

	wfProfileOut(__METHOD__);

	return true;
}

function wfAdEngineSetupJSVars(Array &$vars) {
	wfProfileIn(__METHOD__);

	global $wgRequest, $wgNoExternals, $wgEnableAdsInContent, $wgEnableOpenXSPC,
		$wgAdDriverCookieLifetime, $wgHighValueCountries, $wgDartCustomKeyValues,
		$wgUser, $wgEnableWikiAnswers, $wgAdDriverUseCookie, $wgAdDriverUseExpiryStorage,
		$wgEnableAdMeldAPIClient, $wgEnableAdMeldAPIClientPixels,
		$wgLoadAdDriverOnLiftiumInit, $wgOutboundScreenRedirectDelay,
		$wgEnableOutboundScreenExt;

	$wgNoExternals = $wgRequest->getBool('noexternals', $wgNoExternals);

	if (!empty($wgNoExternals)) {
		$vars["wgNoExternals"] = $wgNoExternals;
	}
	if (!empty($wgEnableAdsInContent)) {
		$vars["wgEnableAdsInContent"] = $wgEnableAdsInContent;
	}
	if (!empty($wgEnableAdMeldAPIClient)) {
		$vars["wgEnableAdMeldAPIClient"] = $wgEnableAdMeldAPIClient;
	}
	if (!empty($wgEnableAdMeldAPIClientPixels)) {
		$vars["wgEnableAdMeldAPIClientPixels"] = $wgEnableAdMeldAPIClientPixels;
	}

	// OpenX SPC (init in AdProviderOpenX.js)
	if (!empty($wgEnableOpenXSPC)) {
		$vars["wgEnableOpenXSPC"] = $wgEnableOpenXSPC;
	}

	// AdDriver
	$vars['wgAdDriverCookieLifetime'] = $wgAdDriverCookieLifetime;
	$highValueCountries = WikiFactory::getVarValueByName('wgHighValueCountries', 177);	// community central
	if (empty($highValueCountries)) {
		$highValueCountries = $wgHighValueCountries;
	}
	$vars['wgHighValueCountries'] = $highValueCountries;

	if (!empty($wgAdDriverUseExpiryStorage)) {
		$vars["wgAdDriverUseExpiryStorage"] = $wgAdDriverUseExpiryStorage;
	}
	if (!empty($wgAdDriverUseCookie)) {
		$vars["wgAdDriverUseCookie"] = $wgAdDriverUseCookie;
	}
	if (!empty($wgLoadAdDriverOnLiftiumInit)) {
		$vars['wgLoadAdDriverOnLiftiumInit'] = $wgLoadAdDriverOnLiftiumInit;
	}

	if ($wgUser->getOption('showAds')) {
		$vars['wgUserShowAds'] = true;
	}

	// Answers sites
	if (!empty($wgEnableWikiAnswers)) {
		$vars['wgEnableWikiAnswers'] = $wgEnableWikiAnswers;
	}

	if (!empty($wgOutboundScreenRedirectDelay)) {
		$vars['wgOutboundScreenRedirectDelay'] = $wgOutboundScreenRedirectDelay;
	}
	if (!empty($wgEnableOutboundScreenExt)) {
		$vars['wgEnableOutboundScreenExt'] = $wgEnableOutboundScreenExt;
	}

	/*
	// Krux
	if (!empty($wgEnableKruxTargeting) && empty($wgNoExternals)) {
		$vars['wgEnableKruxTargeting'] = $wgEnableKruxTargeting;
		$vars['wgKruxCategoryId'] = WikiFactoryHub::getInstance()->getKruxId($cat['id']);
	}
	*/

	wfProfileOut(__METHOD__);
	return true;
}

interface iAdProvider {
	public static function getInstance();
	public function getAd($slotname, $slot, $params = null);
	public function batchCallAllowed();
	public function addSlotToCall($slotname);
	public function getSetupHtml();
	public function getBatchCallHtml();
}

abstract class AdProviderIframeFiller {
	public function getIframeFillHtml($slotname, $slot) {
		wfProfileIn(__METHOD__);

		global $wgEnableAdsLazyLoad, $wgAdslotsLazyLoad;

		$function_name = AdEngine::fillIframeFunctionPrefix . $slotname;
		$out = $this->getIframeFillFunctionDefinition($function_name, $slotname, $slot);
		if (!$wgEnableAdsLazyLoad || empty($wgAdslotsLazyLoad[$slotname]) || empty($this->enable_lazyload)) {
			$out .= "\n".'<script type="text/javascript">' . "$function_name();" . '</script>' . "\n";
		}

		wfProfileOut(__METHOD__);

		return $out;
	}

	abstract protected function getIframeFillFunctionDefinition($function_name, $slotname, $slot);

}

class AdEngine {

	const cacheKeyVersion = "2.03a";
	const cacheTimeout = 1800;
	const lazyLoadAdClass = 'LazyLoadAd';
	const fillIframeFunctionPrefix = 'fillIframe_';
	const fillElemFunctionPrefix = 'fillElem_';

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
		'10' => 'AdDriver',
		'11' => 'LiftDNA',
		'12' => 'DARTGP',
		'13' => 'AdEngine2',
		'14' => 'GamePro',
 		'-1' => 'Null'
	);

	private $slots = array();

	private $placeholders = array();

	private $loadType = 'delayed';

	protected static $instance = false;

	private $adProviders = array();

	protected function __construct($slots = null) {
		wfProfileIn(__METHOD__);

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

		wfProfileOut(__METHOD__);
	}

	/**
	 * @static
	 * @param null $slots
	 * @return AdEngine instance
	 */
	public static function getInstance($slots = null) {
		wfProfileIn(__METHOD__);

		if(self::$instance == false) {
			self::$instance = new AdEngine($slots);
		}

		wfProfileOut(__METHOD__);
		return self::$instance;
	}

	// Load up all the providers. For each one, set up

	public function getSetupHtml(){
		wfProfileIn(__METHOD__);

		global $wgExtensionsPath;

		static $called = false;
		if ($called) {
			wfProfileOut(__METHOD__);
			return false;
		}
		$called = true;

		$out = "<!-- #### BEGIN " . __CLASS__ . '::' . __METHOD__ . " ####-->\n";

		// If loading the ads inline, call the set up html for each provider.
		// If loading delayed, this is done in getDelayedAdLoading method instead.
		if ($this->loadType == 'inline'){
			// for loadType set to inline we have to load AdEngine.js here
			// for loadType set to delayed AdEngine.js should be inside of allinone.js
			$out .= '<script type="text/javascript" src="' . $wgExtensionsPath . '/wikia/AdEngine/AdEngine.js"></script>'. "\n";

			foreach($this->slots as $slotname => $slot) {
				$AdProvider = $this->getAdProvider($slotname);
				// Get setup HTML for each provider. May be empty.
				$out .= $AdProvider->getSetupHtml();
			}
		}

		$out .= "<!-- #### END " . __CLASS__ . '::' . __METHOD__ . " ####-->\n";

		wfProfileOut(__METHOD__);

		return $out;
	}

	public function loadConfig() {
		wfProfileIn(__METHOD__);

		global $wgAdSlots;

		$skin_name = RequestContext::getMain()->getSkin()->getSkinName();

		if ($skin_name === 'answers' || $skin_name === 'lyricsminimal' ){
			$skin_name = 'oasis';
		}

		$this->slots = $wgAdSlots[$skin_name];
		if (empty($this->slots) || !is_array($this->slots)) {
			$this->slots = array();
		}
		foreach ($this->slots as $slot=>&$slotdata) {
			// set provider (for information only)
			$slotdata['provider'] = isset($this->providers[$slotdata['provider_id']]) ? $this->providers[$slotdata['provider_id']] : 'null';
		}
		$this->applyWikiOverrides();

		global $wgDartCustomKeyValues;
		if (!empty($wgDartCustomKeyValues)) {
			// warning, legacy overcomplication ahead
			$dart_key_values = array();
			foreach(explode(";", $wgDartCustomKeyValues) as $keyval) {
				if (!empty($keyval)) {
					list($key, $val) = explode("=", $keyval);
					if (!empty($key) && !empty($val)) {
						$dart_key_values[] = array("keyname" => $key, "keyvalue" => $val);
					}
				}
			}
			if (!empty($dart_key_values)) {
			 foreach($this->slots as $slotname => $slot) {
			 	if($slot['provider_id'] == /* dart */ 1
				|| $slot['provider_id'] == /* AdDriver */ 10){
					$this->slots[$slotname]['provider_values'] = $dart_key_values;
			 	}
			 }
			}
		}

		global $wgShowAds;
		if( empty( $wgShowAds ) ) {
			// clear out all slots except OpenX slots. RT #68545
			foreach ($this->slots as $slotname=>$slot) {
				if ($slot['provider_id'] != 2) {
					unset($this->slots[$slotname]);
				}
			}
		}

		wfProfileOut(__METHOD__);

		return true;
	}


	function getProviderid($provider){
		wfProfileIn(__METHOD__);

		foreach($this->providers as $id => $p) {
			if (strtolower($provider) == strtolower($p) ){
				wfProfileOut(__METHOD__);
				return $id;
			}
		}

		wfProfileOut(__METHOD__);

		// default provider: Null
		return '-1';
	}


	/* Allow Wiki Factory variables to override what is in the slots */
	function applyWikiOverrides(){
		wfProfileIn(__METHOD__);

		foreach($this->slots as $slotname => $slot) {
			$name = 'wgAdslot_' . $slotname;
			if (!empty($GLOBALS[$name])){
				$provider_id = $this->getProviderid($GLOBALS[$name]);
				$this->slots[$slotname]['provider_id'] = $provider_id;
				$this->slots[$slotname]['provider'] = $GLOBALS[$name];
				$this->slots[$slotname]['overridden_by'] = $name;
				$this->slots[$slotname]['enabled'] = "Yes";
			}
		}

		wfProfileOut(__METHOD__);
	}


	/* Simple accessor for slots array */
	public function getSlots() {
		return $this->slots;
	}


	/* Category name/id is needed multiple times for multiple providers. Be gentle on our dbs by adding a thin caching layer. */
	public static function getCachedCategory() {
		wfProfileIn(__METHOD__);

		static $cat;
		if (! empty($cat)){
			wfProfileOut(__METHOD__);
			// This function already called
			return $cat;
		}

		if (!empty($_GET['forceCategory'])){
			wfProfileOut(__METHOD__);
			// Passed in through the url, or hard coded on a test_page. ;-)
			return $_GET['forceCategory'];
		}

		global $wgMemc, $wgCityId, $wgRequest;
		$cacheKey = wfMemcKey(__CLASS__ . 'category', self::cacheKeyVersion);

		$cat = $wgMemc->get($cacheKey);
		if (!empty($cat) && $wgRequest->getVal('action') != 'purge'){
			wfProfileOut(__METHOD__);
			return $cat;
		}

		$hub = WikiFactoryHub::getInstance();
		$cat = array(
			'id'=>$hub->getCategoryId($wgCityId),
			'name'=>$hub->getCategoryName($wgCityId),
			'short'=>$hub->getCategoryShort($wgCityId),
		);

		$wgMemc->set($cacheKey, $cat, self::cacheTimeout);

		wfProfileOut(__METHOD__);

		return $cat;
	}

	// For the provided $slotname, get an ad tag.
	public function getAd($slotname, $params = null) {
		$AdProvider = $this->getAdProvider($slotname);
		return $AdProvider->getAd($slotname, empty($this->slots[$slotname]) ? array() : $this->slots[$slotname], $params);
	}

	/**
	 * assumes all eleemnts in $slotnames are the same ad provider
	 */
	public function getLazyLoadableAdGroup($adGroupName, Array $slotnames, $params=null) {
		if (!sizeof($slotnames)) {
			return '';
		}

		$AdProvider = $this->getAdProvider($slotnames[0]);
		if (method_exists($AdProvider, 'getLazyLoadableAdGroup')) {
			return $AdProvider->getLazyLoadableAdGroup($adGroupName, $slotnames, $params);
		}
		else {
			return '';
		}
	}

	// Logic for hiding/displaying ads should be here, not in the skin.
	public function getAdProvider($slotname) {
		wfProfileIn(__METHOD__);

		global $wgShowAds, $wgUser, $wgNoExternals;


		/* Note: Don't throw an exception on error. Fail gracefully for ads,
		 * don't under any circumstances fail the rendering of the page.
		 * Instead, return a "AdProviderNull" object with an error message.
		 * Note that the second parameter for AdProviderNull constructor
		 * is a boolean for whether or not to log it as an error
		 */

		if (!empty($this->adProviders[$slotname])) {
			wfProfileOut(__METHOD__);
			return $this->adProviders[$slotname];
		}

		// First handle error conditions
		if (!empty($wgNoExternals)){
			$this->adProviders[$slotname] = new AdProviderNull('Externals (including ads) are not allowed right now.');

		} else if (empty($this->slots[$slotname])) {
			$this->adProviders[$slotname] = new AdProviderNull('Unrecognized slot', false);

		} else if ($this->slots[$slotname]['enabled'] == 'No'){
			$this->adProviders[$slotname] = new AdProviderNull("Slot is disabled", false);

		// As long as they are enabled via config, spotlights are always displayed...
		} else if ( $this->getAdType($slotname) == 'spotlight' ){
			$this->adProviders[$slotname] = $this->getProviderFromId($this->slots[$slotname]['provider_id']);

		// Now some toggles based on preferences and logged in/out
		} else if (! $this->isMandatoryAd($slotname) &&
			     empty($_GET['showads']) && $wgShowAds == false ){
			$this->adProviders[$slotname] = new AdProviderNull('$wgShowAds set to false', false);

		} else if (! $this->isMandatoryAd($slotname) && empty($_GET['showads']) &&
			   is_object($wgUser) && $wgUser->isLoggedIn() && !$wgUser->getOption('showAds') ){
			$this->adProviders[$slotname] = new AdProviderNull('User is logged in', false);

		} else if (!empty($_GET['forceProviderid'])){
			// For debugging, allow ad providers to be forced
			$this->adProviders[$slotname] = $this->getProviderFromId($_GET['forceProviderid']);

		// Special case for this type of ad. Not in Athena
		} else if ($slotname == 'RIGHT_SKYSCRAPER_1'){
			$this->adProviders[$slotname] = $this->getProviderFromId($this->slots[$slotname]['provider_id']);

		} else {

			 	$this->adProviders[$slotname] = $this->getProviderFromId($this->slots[$slotname]['provider_id']);
		}

		// Should never happen, but be sure that an AdProvider object is always returned.
		if (empty($this->adProviders[$slotname])) {
			$this->adProviders[$slotname] = new AdProviderNull('Logic error in ' . __METHOD__, true);
		}

		wfProfileOut(__METHOD__);

		return $this->adProviders[$slotname];
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
			case 'addriver': return AdProviderAdDriver::getInstance();
			case 'liftdna': return AdProviderLiftDNA::getInstance();
			case 'dartgp': return AdProviderDARTGP::getInstance();
			case 'adengine2': return AdProviderAdEngine2::getInstance();
			case 'gamepro': return AdProviderGamePro::getInstance();
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
	public static function getHeightWidthFromSize($size) {
		if (preg_match('/^([0-9]{2,4})x([0-9]{2,4}|\*)/', $size, $matches)) {
			return array(
				'width' => $matches[1],
				'height' => $matches[2]
			);
		}
		return false;
	}

	public function getPlaceHolderIframe($slotname, $reserveSpace=true){
		wfProfileIn(__METHOD__);

		global $wgEnableAdsLazyLoad, $wgAdslotsLazyLoad;

		$html = null;
		wfRunHooks("fillInAdPlaceholder", array("iframe", $slotname, &$this, &$html));
		if (!empty($html)) {
			wfProfileOut(__METHOD__);
			return $html;
		}

		$AdProvider = $this->getAdProvider($slotname);
		// If it's a Null Ad, just return an empty comment, and don't store in place holder array.
		if ($AdProvider instanceof AdProviderNull){
			wfProfileOut(__METHOD__);
			return "<!-- Null Ad from " . __METHOD__ . "-->" . $AdProvider->getAd($slotname, array());
		}

		// FIXME make it more general...
		if ($AdProvider instanceof AdProviderGAM){
			wfProfileOut(__METHOD__);
			return "<!-- Fall back to getAd from " . __METHOD__ . "-->" . $this->getAd($slotname);
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
		if (!empty($wgEnableAdsLazyLoad)) {
			if (!empty($wgAdslotsLazyLoad[$slotname])) {
				if (!empty($AdProvider->enable_lazyload)) {
					$slotiframe_class = self::lazyLoadAdClass;
				}
			}
		}

		$style = '';
		if($slotname == 'PREFOOTER_LEFT_BOXAD' || $slotname == 'PREFOOTER_RIGHT_BOXAD' || $slotname == 'LEFT_SKYSCRAPER_2' || $slotname == 'LEFT_SKYSCRAPER_3') {
			$style = ' style="display:none;"';
		}

		wfProfileOut(__METHOD__);

		return '<div id="' . htmlspecialchars($slotname) . '" class="wikia-ad noprint"'.$style.'>' .
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
		wfProfileIn(__METHOD__);

		$html = null;
		wfRunHooks("fillInAdPlaceholder", array("div", $slotname, &$this, &$html));
		if (!empty($html)) {
			wfProfileOut(__METHOD__);
			return $html;
		}

		$AdProvider = $this->getAdProvider($slotname);
		// If it's a Null Ad, just return an empty comment, and don't store in place holder array.
		if ($AdProvider instanceof AdProviderNull){
			wfProfileOut(__METHOD__);
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

		wfProfileOut(__METHOD__);

		return "<div id=\"$slotname\"$style></div>";
	}

	public function getDelayedLoadingCode(){
		wfProfileIn(__METHOD__);

		if (empty($this->placeholders)){
			wfProfileOut(__METHOD__);
			// No delayed ads on this page
			return '<!-- No placeholders called for ' . __METHOD__ . " -->\n";
		}

		// Sort by load_priority
		asort($this->placeholders);
		$this->placeholders = array_reverse($this->placeholders);

		$out = "<!-- #### BEGIN " . __CLASS__ . '::' . __METHOD__ . " ####-->\n";

		// Get the setup code for ad providers used on this page. This is for Ad Providers that support multi-call.
		foreach ($this->placeholders as $slotname => $load_priority) {
			$AdProvider = $this->getAdProvider($slotname);

			// Get setup HTML for each provider. May be empty.
			$out .= $AdProvider->getSetupHtml();
		}

		foreach ($this->placeholders as $slotname => $load_priority) {
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
		wfProfileOut(__METHOD__);
		return $out;
	}

	public function getDelayedIframeLoadingCode(){
		wfProfileIn(__METHOD__);

		if (empty($this->placeholders)){
			wfProfileOut(__METHOD__);
			// No delayed ads on this page
			return '<!-- No iframe placeholders called for ' . __METHOD__ . " -->\n";
		}

		// Sort by load_priority
		asort($this->placeholders);
		$this->placeholders = array_reverse($this->placeholders);

		$out = "<!-- #### BEGIN " . __CLASS__ . '::' . __METHOD__ . " ####-->\n";

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
		wfProfileOut(__METHOD__);
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
			case '269x143': return 'spotlight';
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
		wfProfileIn(__METHOD__);

		$this->loadType = $loadType;
		if ($loadType == 'inline'){
			// Fill in slotsToCall with a list of slotnames that will be used. Needed for getBatchCallHtml
			foreach($this->slots as $slotname => $slot) {
				$AdProvider = $this->getAdProvider($slotname);
				$AdProvider->addSlotToCall($slotname);
			}
		}

		wfProfileOut(__METHOD__);
	}

	public function getSlotNamesForProvider($provider_id){
		wfProfileIn(__METHOD__);

		$out = array();
		foreach($this->slots as $slotname => $data ){
			if ($data['enabled'] == 'Yes' && $data['provider_id'] == $provider_id){
				$out [] = $slotname;
			}
		}
		wfProfileOut(__METHOD__);
		return $out;
	}

	public function getProviderNameForSlotname($slotname) {
		return isset($this->slots[$slotname]) &&
			isset($this->slots[$slotname]['provider_id']) &&
			isset($this->providers[$this->slots[$slotname]['provider_id']])
			? $this->providers[$this->slots[$slotname]['provider_id']]
			: '';
	}

	public static function isAdsEnabledOnWikiaHub() {
		global $wgHubsAdsEnabled, $wgTitle;

		if (WikiaPageType::isWikiaHub() && !empty($wgHubsAdsEnabled)) {
			if (in_array($wgTitle->getBaseText(), $wgHubsAdsEnabled)) {
				return true;
			}
		}
		return false;
	}

	private function isMandatoryAd($slotname) {
		/* Ads that always display, even if user is logged in, etc.
		 * See http://staff.wikia-inc.com/wiki/DART_Implementation#When_to_show_ads */
		$mandatoryAds = array(
			'HOME_TOP_LEADERBOARD',
			'HOME_TOP_RIGHT_BOXAD',
			'LEFT_NAV_205x400'
		);

		// Certain ads always display
		return (
			$this->getAdType($slotname) == 'spotlight'
			|| in_array($slotname, $mandatoryAds)
		);
	}

	public static function getLiftiumOptionsScript() {
		wfProfileIn(__METHOD__);

		global $wgDBname, $wgTitle, $wgLang;

		// See Liftium.js for documentation on options
		$options = array();
		$options['pubid'] = 999;
		$options['baseUrl'] = '/__varnish_liftium/';
		$options['kv_wgDBname'] = $wgDBname;
		if (is_object($wgTitle)){
		       $options['kv_article_id'] = $wgTitle->getArticleID();
		       $options['kv_wpage'] = $wgTitle->getPartialURL();
		}
		$cat = AdEngine::getCachedCategory();
		$options['kv_Hub'] = $cat['name'];
		$options['kv_skin'] = RequestContext::getMain()->getSkin()->getSkinName();
		$options['kv_user_lang'] = $wgLang->getCode();
		$options['kv_cont_lang'] = $GLOBALS['wgLanguageCode'];
		$options['kv_isMainPage'] = WikiaPageType::isMainPage();
		$options['kv_page_type'] = WikiaPageType::getPageType();
		$options['geoUrl'] = "http://geoiplookup.wikia.com/";
		if (!empty($wgDartCustomKeyValues)) {
			$options['kv_dart'] = $wgDartCustomKeyValues;
		}

		$options['kv_domain'] = $_SERVER['HTTP_HOST'];
		$options['hasMoreCalls'] = true;
		$options['isCalledAfterOnload'] = true;
		$options['maxLoadDelay'] = 6000;

		$js = "LiftiumOptions = " . json_encode($options) . ";\n";

		$out = "\n<!-- Liftium options -->\n";
		$out .= Html::inlineScript( $js )."\n";

		wfProfileOut(__METHOD__);

		return $out;
	}

}
