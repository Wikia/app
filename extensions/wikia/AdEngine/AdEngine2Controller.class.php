<?php

/**
 * AdEngine II Controller
 */
class AdEngine2Controller extends WikiaController {
	const ASSET_GROUP_CORE = 'oasis_shared_core_js';
	const ASSET_GROUP_ADENGINE = 'adengine2_js';

	const AD_LEVEL_NONE = 'none';           // show no ads
	const AD_LEVEL_LIMITED = 'limited';     // show some ads (logged in users on main page)
	const AD_LEVEL_CORPORATE = 'corporate'; // show some ads (anonymous users on corporate pages)
	const AD_LEVEL_ALL = 'all';             // show all ads

	private static $slotsDisplayShinyAdSelfServe = ['CORP_TOP_RIGHT_BOXAD', 'HOME_TOP_RIGHT_BOXAD', 'TEST_TOP_RIGHT_BOXAD', 'TOP_RIGHT_BOXAD'];

	/*
	 * Public static methods for querying ad engine for ad states
	 */

	/**
	 * Get ad level for the current page. Take into account type of the page and user status.
	 * Return one of the AD_LEVEL_* const
	 *
	 * @return string
	 */
	public static function getAdLevelForPage() {
		$wg = F::app()->wg;

		static $pageLevel = null;

		if ($pageLevel) {
			return $pageLevel;
		}

		if (WikiaPageType::isActionPage()
			|| $wg->Request->getBool('noexternals', $wg->NoExternals)
			|| $wg->Request->getBool('noads', false)
			|| $wg->ShowAds === false
			|| $wg->EnableAdEngineExt === false
			|| !F::app()->checkSkin(['oasis'])
		) {
			$pageLevel = self::AD_LEVEL_NONE;
			return $pageLevel;
		}

		$runAds = WikiaPageType::isSearch()
			|| WikiaPageType::isForum()
			|| WikiaPageType::isWikiaHub();

		if (!$runAds) {
			if ($wg->Title) {
				$title = $wg->Title;
				$namespace = $title->getNamespace();
				$runAds = in_array($namespace, $wg->ContentNamespaces)
					|| isset($wg->ExtraNamespaces[$namespace])

				// Blogs:
					|| BodyController::isBlogListing()
					|| BodyController::isBlogPost()

				// Quiz, category and project pages:
					|| (defined('NS_WIKIA_PLAYQUIZ') && $title->inNamespace(NS_WIKIA_PLAYQUIZ))
					|| (defined('NS_CATEGORY') && $namespace == NS_CATEGORY)
					|| (defined('NS_PROJECT') && $namespace == NS_PROJECT)

				// Chosen special pages:
					|| $title->isSpecial('Videos')
					|| $title->isSpecial('Leaderboard');
			}
		}

		if (!$runAds) {
			$pageLevel = self::AD_LEVEL_NONE;
			return $pageLevel;
		}

		$user = $wg->User;
		if (!$user->isLoggedIn() || $user->getOption('showAds')) {
			// Only leaderboard, medrec and invisible on corporate sites for anonymous users
			if ($wg->EnableWikiaHomePageExt) {
				$pageLevel = self::AD_LEVEL_CORPORATE;
				return $pageLevel;
			}

			// All ads everywhere else
			$pageLevel = self::AD_LEVEL_ALL;
			return $pageLevel;
		}

		// Logged in users get some ads on the main pages (except on the corporate sites)
		if (!$wg->EnableWikiaHomePageExt && WikiaPageType::isMainPage()) {
			$pageLevel = self::AD_LEVEL_LIMITED;
			return $pageLevel;
		}

		// Override ad level for a (set of) specific page(s)
		// Use case: sponsor ads on a landing page targeted to Wikia editors (=logged in)
		if ($wg->Title &&
			!empty($wg->PagesWithNoAdsForLoggedInUsersOverriden) &&
			in_array($wg->Title->getDBkey(), $wg->PagesWithNoAdsForLoggedInUsersOverriden))
		{
			$pageLevel = self::AD_LEVEL_CORPORATE;
			if (!empty($wg->PagesWithNoAdsForLoggedInUsersOverriden_AD_LEVEL) &&
				in_array($wg->PagesWithNoAdsForLoggedInUsersOverriden_AD_LEVEL, array(
					self::AD_LEVEL_NONE, self::AD_LEVEL_LIMITED, self::AD_LEVEL_CORPORATE, self::AD_LEVEL_ALL
				)))
			{
				$pageLevel = $wg->PagesWithNoAdsForLoggedInUsersOverriden_AD_LEVEL;
			}
			return $pageLevel;
		}

		// And no other ads
		$pageLevel = self::AD_LEVEL_NONE;
		return $pageLevel;
	}

	public static function getAdLevelForSlot($slotname) {
		if ($slotname === 'INVISIBLE_1' || $slotname === 'INVISIBLE_SKIN') {
			return self::AD_LEVEL_CORPORATE;
		}

		if (preg_match('/TOP_LEADERBOARD|TOP_RIGHT_BOXAD|GPT_FLUSH/', $slotname)) {
			return self::AD_LEVEL_LIMITED;
		}
		return self::AD_LEVEL_ALL;
	}

	public static function compareAdLevels($level1, $level2) {
		if ($level1 === $level2) {
			return 0;
		}
		if ($level1 === self::AD_LEVEL_NONE || $level2 === self::AD_LEVEL_ALL) {
			// $level1 < $level2
			return -1;
		}
		if ($level1 === self::AD_LEVEL_ALL || $level2 === self::AD_LEVEL_NONE) {
			// $level1 > $level2
			return 1;
		}
		if ($level1 === self::AD_LEVEL_LIMITED) {
			// $level2 === self::AD_LEVEL_CORPORATE
			// $level1 < $level2
			return -1;
		}
		// $level1 === self::AD_LEVEL_CORPORATE, $level2 === self::AD_LEVEL_LIMITED
		// $level1 > $level2
		return 1;
	}

	/**
	 * Check if for current page the ads can be displayed or not.
	 *
	 * @return bool
	 */
	public static function areAdsShowableOnPage() {
		return (self::getAdLevelForPage() !== self::AD_LEVEL_NONE);
	}

	public static function getAdsInHeadGroup() {
		static $cached = null;

		if ($cached === null) {
			if (F::app()->wg->LoadAdsInHead) {
				// Get into a random 50/50 group:
				$cached = mt_rand(1, 2);
			} else {
				$cached = 0;
			}

			// Override from URL
			$cached = F::app()->wg->Request->getInt('adsinhead', $cached);

			// Only accept 0, 1 and 2
			if ($cached > 2 || $cached < 0) {
				$cached = 0;
			}
		}

		return $cached;
	}

	public static function areAdsInHead() {
		return self::getAdsInHeadGroup() === 1;
	}

	// Category name/id is needed multiple times for multiple providers. Be gentle on our dbs by adding a thin caching layer
	const cacheKeyVersion = "2.03a";
	const cacheTimeout = 1800;

	// TODO: move the caching to HubService (if not present yet) and remove it from here
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

	public static function getLiftiumOptionsScript() {
		wfProfileIn(__METHOD__);

		global $wgDBname, $wgTitle, $wgLang, $wgDartCustomKeyValues;

		// See Liftium.js for documentation on options
		$options = array();
		$options['pubid'] = 999;
		$options['baseUrl'] = '/__varnish_liftium/';
		$options['kv_wgDBname'] = $wgDBname;
		if (is_object($wgTitle)){
			$options['kv_article_id'] = $wgTitle->getArticleID();
			$options['kv_wpage'] = $wgTitle->getPartialURL();
		}
		$cat = AdEngine2Controller::getCachedCategory();
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

	/**
	 * Action to display an ad (or not)
	 */
	public function ad() {
		$wgEnableShinyAdsSelfServeUrl = $this->wg->EnableShinyAdsSelfServeUrl;
		$wgShinyAdsSelfServeUrl = $this->wg->ShinyAdsSelfServeUrl;

		$this->slotname = $this->request->getVal('slotname');

		$this->selfServeUrl = null;
		if ($wgEnableShinyAdsSelfServeUrl && $wgShinyAdsSelfServeUrl) {
			if (array_search($this->slotname, self::$slotsDisplayShinyAdSelfServe) !== FALSE) {
				$this->selfServeUrl = $wgShinyAdsSelfServeUrl;
			}
		}

		$this->pageLevel = self::getAdLevelForPage();
		$this->slotLevel = self::getAdLevelForSlot($this->slotname);

		$this->showAd = (self::compareAdLevels($this->pageLevel, $this->slotLevel) >= 0);
	}

	/*
	 * Hooks
	 */

	/**
	 * Register global JS variables bottom (migrated from wfAdEngineSetupJSVars)
	 *
	 * @param array $vars
	 * @param array $scripts
	 *
	 * @return bool
	 */
	static public function onMakeGlobalVariablesScript(array &$vars) {
		wfProfileIn(__METHOD__);

		global $wgRequest, $wgNoExternals, $wgEnableAdsInContent, $wgEnableOpenXSPC,
			   $wgAdDriverCookieLifetime, $wgHighValueCountries,
			   $wgUser, $wgEnableWikiAnswers, $wgAdDriverUseCookie, $wgAdDriverUseExpiryStorage,
			   $wgEnableAdMeldAPIClient, $wgEnableAdMeldAPIClientPixels,
			   $wgLoadAdDriverOnLiftiumInit, $wgOutboundScreenRedirectDelay,
			   $wgEnableOutboundScreenExt, $wgAdDriverUseSevenOneMedia;

		$wgNoExternals = $wgRequest->getBool('noexternals', $wgNoExternals);

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
		if (!empty($wgAdDriverUseSevenOneMedia)) {
			$vars["wgAdDriverUseSevenOneMedia"] = $wgAdDriverUseSevenOneMedia;
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

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Register ad-related vars on top (migrated from wfAdEngineSetupTopVars)
	 *
	 * @param array $vars
	 * @param array $scripts
	 *
	 * @return bool
	 */
	static public function onWikiaSkinTopScriptsLegacy(&$vars, &$scripts) {
		global $wgCityId, $wgEnableKruxTargeting, $wgNoExternals;

		wfProfileIn(__METHOD__);

		// generic type of page: forum/search/article/home/...
		$vars['wikiaPageType'] = WikiaPageType::getPageType();
		$vars['wikiaPageIsHub'] = WikiaPageType::isWikiaHub();

		// category/hub
		$catInfo = HubService::getComscoreCategory($wgCityId);
		$vars['cscoreCat'] = $catInfo->cat_name;

		// Krux
		$cat = AdEngine2Controller::getCachedCategory();
		if (!empty($wgEnableKruxTargeting) && empty($wgNoExternals)) {
			$vars['wgEnableKruxTargeting'] = $wgEnableKruxTargeting;
			$vars['wgKruxCategoryId'] = WikiFactoryHub::getInstance()->getKruxId($cat['id']);
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Register ad-related vars on top
	 *
	 * @param array $vars
	 * @param array $scripts
	 *
	 * @return bool
	 */
	static public function onWikiaSkinTopScripts(&$vars, &$scripts) {
		wfProfileIn(__METHOD__);
		$wg = F::app()->wg;

		$req = $wg->Request;

		// AdEngine2.js
		$vars['adslots2'] = array();
		$vars['wgLoadAdsInHead'] = self::areAdsInHead();
		$vars['wgAdsInHeadGroup'] = self::getAdsInHeadGroup();

		// TODO: clean up
		$vars['wgAdsShowableOnPage'] = self::areAdsShowableOnPage();
		$vars['wgShowAds'] = self::areAdsShowableOnPage();

		$vars['wgAdVideoTargeting'] = $req->getBool('videotargeting', (bool) $wg->AdVideoTargeting);
		$vars['wgAdDriverStartLiftiumOnLoad'] = $req->getBool('liftiumonload', (bool) $wg->LiftiumOnLoad);

		// Used to hop by DART ads
		$vars['adDriverLastDARTCallNoAds'] = array();

		// WikiaDartHelper.js
		if (!empty($wg->DartCustomKeyValues)) {
			$vars['wgDartCustomKeyValues'] = $wg->DartCustomKeyValues;
		}
		$cat = self::getCachedCategory();
		$vars['cityShort'] = $cat['short'];

		// 3rd party code (eg. dart collapse slot template) can force AdDriver2 to respect unusual slot status
		$vars['adDriver2ForcedStatus'] = array();

		$vars['wgWikiDirectedAtChildren'] = (bool) $wg->WikiDirectedAtChildrenByStaff;

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Modify assets appended to the bottom of the page
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	static public function onOasisSkinAssetGroups(&$jsAssets) {
		$coreGroupIndex = array_search(self::ASSET_GROUP_CORE, $jsAssets);
		if ($coreGroupIndex === false) {
			// Do nothing. oasis_shared_core_js must be present for ads to work
			return true;
		}

		if (!self::areAdsInHead()) {
			// Add ad asset to JavaScripts loaded on bottom (with regular JavaScripts)
			array_splice($jsAssets, $coreGroupIndex + 1, 0, self::ASSET_GROUP_ADENGINE);
		}
		return true;
	}

	/**
	 * Modify assets appended to the top of the page
	 *
	 * @param array $jsAssets
	 *
	 * @return bool
	 */
	static public function onOasisSkinAssetGroupsBlocking(&$jsAssets) {
		if (self::areAdsInHead()) {
			// Add ad asset to JavaScripts loaded on top (in <head>)
			$jsAssets[] = self::ASSET_GROUP_ADENGINE;
		}
		return true;
	}

	static public function onWikiaSkinTopModules(&$scriptModules, $skin) {
		if (self::areAdsInHead() || AnalyticsProviderAmazonDirectTargetedBuy::isEnabled()) {
			$scriptModules[] = 'wikia.cookies';
			$scriptModules[] = 'wikia.geo';
			$scriptModules[] = 'wikia.window';
		}
		if (self::areAdsInHead()) {
			$scriptModules[] = 'wikia.location';
			$scriptModules[] = 'wikia.log';
			$scriptModules[] = 'wikia.querystring';
			$scriptModules[] = 'wikia.tracker';
		}
		return true;
	}

	/**
	 * Deal with external interwiki links: add exitstitial class to them if needed
	 *
	 * @param $skin
	 * @param $target
	 * @param $options
	 * @param $text
	 * @param $attribs
	 * @param $ret
	 *
	 * @return bool
	 */
	static public function onLinkEnd($skin, Title $target, array $options, &$text, array &$attribs, &$ret) {
		if ($target->isExternal()) {
			static::handleExternalLink($attribs['href'], $attribs);
		}
		return true;
	}

	/**
	 * Deal with external links: add exitstitial class to them if needed
	 *
	 * @param $url
	 * @param $text
	 * @param $link
	 * @param $attribs
	 *
	 * @return bool
	 */
	static function onLinkerMakeExternalLink(&$url, &$text, &$link, &$attribs) {
		static::handleExternalLink($url, $attribs);
		return true;
	}

	/**
	 * Add exitstitial class to the external links pointing to not-whitelisted domains
	 * if $wgEnableOutboundScreenExt is set, user is anonymous, not in editor, etc
	 *
	 * @param $url
	 * @param $attribs
	 *
	 * @return null
	 */
	static private function handleExternalLink($url, &$attribs) {
		$wg = F::app()->wg;
		if (!$wg->EnableOutboundScreenExt
			|| $wg->RTEParserEnabled    // skip logic when in FCK
			|| empty($wg->Title)        // setup functions can call MakeExternalLink before wgTitle is set RT#144229
			|| $wg->User->isLoggedIn()  // logged in users have no exit stitial ads
			|| strpos($url, 'http://') !== 0
		) {
			return;
		}

		foreach (static::getExitstitialUrlsWhiteList() as $whiteListedUrl) {
			if (preg_match('/' . preg_quote($whiteListedUrl) . '/i', $url)) {
				return;
			}
		}

		if (isset($attribs['class'])) {
			$attribs['class'] .= ' exitstitial';
		}
	}

	static private function getExitstitialUrlsWhiteList() {
		static $whiteList = null;

		$wg = F::app()->wg;

		if (is_array($whiteList)) {
			return $whiteList;
		}

		$whiteList = [];
		$whiteListContent = wfMsgExt('outbound-screen-whitelist', array('language' => 'en'));

		if (!empty($whiteListContent)) {
			$lines = explode("\n", $whiteListContent);
			foreach($lines as $line) {
				if(strpos($line, '* ') === 0 ) {
					$whiteList[] = trim($line, '* ');
				}
			}
		}

		$wikiDomains = WikiFactory::getDomains($wg->CityId);
		if ($wikiDomains !== false) {
			$whiteList = array_merge($wikiDomains, $whiteList);
		}

		// Devboxes run on different domains than just what is in WikiFactory.
		if ($wg->DevelEnvironment && !empty($_SERVER['SERVER_NAME'])) {
			array_unshift($whiteList, $_SERVER['SERVER_NAME']);
		}

		return $whiteList;
	}
}
