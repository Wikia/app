<?php

/**
 * AdEngine II Controller
 */
class AdEngine2Controller extends WikiaController {
	const ASSET_GROUP_CORE = 'oasis_shared_core_js';
	const ASSET_GROUP_ADENGINE = 'adengine2_js';

	const AD_LEVEL_NONE = 'none';           // show no ads
	const AD_LEVEL_LIMITED = 'limited';     // show some ads (logged in users on main page)
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
		) {
			$pageLevel = self::AD_LEVEL_NONE;
			return $pageLevel;
		}

		$runAds = $wg->Out->isArticle()
			|| WikiaPageType::isSearch()
			|| WikiaPageType::isForum()
			|| WikiaPageType::isWikiaHub();

		if (!$runAds) {
			if ($wg->Title) {
				$runAds = (defined('NS_WIKIA_PLAYQUIZ') && $wg->Title->inNamespace(NS_WIKIA_PLAYQUIZ))
					|| $wg->Title->isSpecial('Videos')
					|| $wg->Title->isSpecial('Leaderboard');
			}
		}

		if (!$runAds) {
			$pageLevel = self::AD_LEVEL_NONE;
			return $pageLevel;
		}

		// Anonymous users get all ads
		$user = $wg->User;
		if (!$user->isLoggedIn() || $user->getOption('showAds')) {
			$pageLevel = self::AD_LEVEL_ALL;
			return $pageLevel;
		}

		// Logged in get some ads on the main page
		if (WikiaPageType::isMainPage()) {
			$pageLevel = self::AD_LEVEL_LIMITED;
			return $pageLevel;
		}

		$pageLevel = self::AD_LEVEL_NONE;
		return $pageLevel;
	}

	public static function getAdLevelForSlot($slotname) {
		if (preg_match('/TOP_LEADERBOARD|TOP_RIGHT_BOXAD/', $slotname)) {
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

	const cacheKeyVersion = "2.03a";
	const cacheTimeout = 1800;
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
	 * Register ad-related vars on top
	 *
	 * @param array $vars
	 * @param array $scripts
	 *
	 * @return bool
	 */
	public function onWikiaSkinTopScripts(&$vars, &$scripts) {
		wfProfileIn(__METHOD__);

		$req = $this->wg->Request;

		// AdEngine2.js
		$vars['adslots2'] = array();
		$vars['wgLoadAdsInHead'] = self::areAdsInHead();
		$vars['wgAdsInHeadGroup'] = self::getAdsInHeadGroup();
		$vars['wgAdsShowableOnPage'] = self::areAdsShowableOnPage();
		$vars['wgShowAds'] = $this->wg->ShowAds;

		$vars['wgAdDriverUseGpt'] = $req->getBool('usegpt', (bool) $this->wg->AdDriverUseGpt);
		$vars['wgAdDriverStartLiftiumOnLoad'] = $req->getBool('liftiumonload', (bool) $this->wg->LiftiumOnLoad);

		// Used to hop by DART ads
		$vars['adDriverLastDARTCallNoAds'] = array();

		// WikiaDartHelper.js
		if (!empty($this->wg->DartCustomKeyValues)) {
			$vars['wgDartCustomKeyValues'] = $this->wg->DartCustomKeyValues;
		}
		$cat = self::getCachedCategory();
		$vars['cityShort'] = $cat['short'];

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
	public function onOasisSkinAssetGroups(&$jsAssets) {
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
	public function onOasisSkinAssetGroupsBlocking(&$jsAssets) {
		if (self::areAdsInHead()) {
			// Add ad asset to JavaScripts loaded on top (in <head>)
			$jsAssets[] = self::ASSET_GROUP_ADENGINE;
		}
		return true;
	}

	public function onWikiaSkinTopModules(&$scriptModules, $skin) {
		if (self::areAdsInHead() || AnalyticsProviderAmazonDirectTargetedBuy::isEnabled()) {
			$scriptModules[] = 'wikia.window';
			$scriptModules[] = 'wikia.cookies';
			$scriptModules[] = 'wikia.geo';
			$scriptModules[] = 'wikia.window';
		}
		if (self::areAdsInHead()) {
			$scriptModules[] = 'wikia.location';
			$scriptModules[] = 'wikia.log';
			$scriptModules[] = 'wikia.querystring';
			$scriptModules[] = 'wikia.tracker';
			$scriptModules[] = 'wikia.window';
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
	public function onLinkEnd($skin, Title $target, array $options, &$text, array &$attribs, &$ret) {
		if ($target->isExternal()) {
			$this->handleExternalLink($attribs['href'], $attribs);
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
	public function onLinkerMakeExternalLink(&$url, &$text, &$link, &$attribs) {
		$this->handleExternalLink($url, $attribs);
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
	private function handleExternalLink($url, &$attribs) {
		if (!$this->wg->EnableOutboundScreenExt
			|| $this->wg->RTEParserEnabled    // skip logic when in FCK
			|| empty($this->wg->Title)        // setup functions can call MakeExternalLink before wgTitle is set RT#144229
			|| $this->wg->User->isLoggedIn()  // logged in users have no exit stitial ads
			|| strpos($url, 'http://') !== 0
		) {
			return;
		}

		foreach ($this->getExitstitialUrlsWhiteList() as $whiteListedUrl) {
			if (preg_match('/' . preg_quote($whiteListedUrl) . '/i', $url)) {
				return;
			}
		}

		$attribs['class'] .= ' exitstitial';
	}

	private function getExitstitialUrlsWhiteList() {
		static $whiteList = null;

		if (is_array($whiteList)) {
			return $whiteList;
		}

		$whiteList = [];
		$whiteListContent = $this->wf->MsgExt('outbound-screen-whitelist', array('language' => 'en'));

		if (!empty($whiteListContent)) {
			$lines = explode("\n", $whiteListContent);
			foreach($lines as $line) {
				if(strpos($line, '* ') === 0 ) {
					$whiteList[] = trim($line, '* ');
				}
			}
		}

		$wikiDomains = WikiFactory::getDomains($this->wg->CityId);
		if ($wikiDomains !== false) {
			$whiteList = array_merge($wikiDomains, $whiteList);
		}

		// Devboxes run on different domains than just what is in WikiFactory.
		if ($this->wg->DevelEnvironment && !empty($_SERVER['SERVER_NAME'])) {
			array_unshift($whiteList, $_SERVER['SERVER_NAME']);
		}

		return $whiteList;
	}
}
