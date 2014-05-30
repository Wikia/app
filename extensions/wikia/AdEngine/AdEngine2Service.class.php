<?php

class AdEngine2Service
{

	const ASSET_GROUP_CORE = 'oasis_shared_core_js';
	const ASSET_GROUP_ADENGINE = 'adengine2_js';
	const ASSET_GROUP_ADENGINE_LATE = 'adengine2_late_js';
	const ASSET_GROUP_LIFTIUM = 'liftium_ads_js';

	const PAGE_TYPE_NO_ADS = 'no_ads';                   // show no ads
	const PAGE_TYPE_HOMEPAGE_LOGGED = 'homepage_logged'; // show some ads (logged in users on main page)
	const PAGE_TYPE_CORPORATE = 'corporate';             // show some ads (anonymous users on corporate pages)
	const PAGE_TYPE_ALL_ADS = 'all_ads';                 // show all ads!

	const cacheKeyVersion = "2.03a";
	const cacheTimeout = 1800;

	private $_allPageTypes = [
		self::PAGE_TYPE_NO_ADS,
		self::PAGE_TYPE_HOMEPAGE_LOGGED,
		self::PAGE_TYPE_CORPORATE,
		self::PAGE_TYPE_ALL_ADS
	];

	/**
	 * Get page type for the current page (ad-wise).
	 * Take into account type of the page and user status.
	 * Return one of the PAGE_TYPE_* const
	 *
	 * @return string
	 */
	public static function getPageType()
	{
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
			$pageLevel = self::PAGE_TYPE_NO_ADS;
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
			$pageLevel = self::PAGE_TYPE_NO_ADS;
			return $pageLevel;
		}

		$user = $wg->User;
		if (!$user->isLoggedIn() || $user->getOption('showAds')) {
			// Only leaderboard, medrec and invisible on corporate sites for anonymous users
			if (WikiaPageType::isCorporatePage()) {
				$pageLevel = self::PAGE_TYPE_CORPORATE;
				return $pageLevel;
			}

			// All ads everywhere else
			$pageLevel = self::PAGE_TYPE_ALL_ADS;
			return $pageLevel;
		}

		// Logged in users get some ads on the main pages (except on the corporate sites)
		if (!WikiaPageType::isCorporatePage() && WikiaPageType::isMainPage()) {
			$pageLevel = self::PAGE_TYPE_HOMEPAGE_LOGGED;
			return $pageLevel;
		}

		// Override ad level for a (set of) specific page(s)
		// Use case: sponsor ads on a landing page targeted to Wikia editors (=logged in)
		if ($wg->Title &&
			!empty($wg->PagesWithNoAdsForLoggedInUsersOverriden) &&
			in_array($wg->Title->getDBkey(), $wg->PagesWithNoAdsForLoggedInUsersOverriden)
		) {
			$pageLevel = self::PAGE_TYPE_CORPORATE;
			return $pageLevel;
		}

		// And no other ads
		$pageLevel = self::PAGE_TYPE_NO_ADS;
		return $pageLevel;
	}

	public static function shouldShowAd($pageTypes = null)
	{
		$pageType = self::getPageType();

		if ($pageTypes === null) {
			$pageTypes = [self::PAGE_TYPE_ALL_ADS];
		}

		if (in_array('*', $pageTypes) && $pageType !== self::PAGE_TYPE_NO_ADS) {
			return true;
		}

		return in_array($pageType, $pageTypes);
	}

	public static function shouldLoadLiftium()
	{
		global $wgEnableRHonDesktop, $wgAdEngineDisableLateQueue;
		return !$wgEnableRHonDesktop && !$wgAdEngineDisableLateQueue;
	}

	public static function shouldLoadLateQueue()
	{
		global $wgAdEngineDisableLateQueue;
		return !$wgAdEngineDisableLateQueue;
	}

	/**
	 * Check if for current page the ads can be displayed or not.
	 *
	 * @return bool
	 */
	public static function areAdsShowableOnPage()
	{
		return (self::getPageType() !== self::PAGE_TYPE_NO_ADS);
	}

	public static function areAdsInHead()
	{
		global $wgLoadAdsInHead;
		return $wgLoadAdsInHead;
	}

	public static function getCachedCategory()
	{
		wfProfileIn(__METHOD__);

		static $cat;
		if (!empty($cat)) {
			wfProfileOut(__METHOD__);
			// This function already called
			return $cat;
		}

		if (!empty($_GET['forceCategory'])) {
			wfProfileOut(__METHOD__);
			// Passed in through the url, or hard coded on a test_page. ;-)
			return $_GET['forceCategory'];
		}

		global $wgMemc, $wgCityId, $wgRequest;
		$cacheKey = wfMemcKey(__CLASS__ . 'category', self::cacheKeyVersion);

		$cat = $wgMemc->get($cacheKey);
		if (!empty($cat) && $wgRequest->getVal('action') != 'purge') {
			wfProfileOut(__METHOD__);
			return $cat;
		}

		$hub = WikiFactoryHub::getInstance();
		$cat = array(
			'id' => $hub->getCategoryId($wgCityId),
			'name' => $hub->getCategoryName($wgCityId),
			'short' => $hub->getCategoryShort($wgCityId),
		);

		$wgMemc->set($cacheKey, $cat, self::cacheTimeout);

		wfProfileOut(__METHOD__);

		return $cat;
	}

	/**
	 * Get all the variables that should be exposed to JavaScript
	 *
	 * @return array
	 */
	private static function getJsVariables()
	{
		global $wgCityId, $wgEnableAdsInContent, $wgEnableOpenXSPC,
			$wgUser, $wgEnableAdMeldAPIClient, $wgEnableAdMeldAPIClientPixels,
			$wgOutboundScreenRedirectDelay, $wgEnableOutboundScreenExt,
			$wgAdDriverUseSevenOneMedia, $wgAdDriverUseEbay,
			$wgAdPageLevelCategoryLangs, $wgLanguageCode, $wgAdDriverTrackState,
			$wgAdDriverForceDirectGptAd, $wgAdDriverForceLiftiumAd,
			$wgOasisResponsive, $wgOasisResponsiveLimited,
			$wgEnableRHonDesktop, $wgAdPageType, $wgOut,
			$wgRequest, $wgEnableKruxTargeting,
			$wgAdVideoTargeting, $wgLiftiumOnLoad,
			$wgDartCustomKeyValues, $wgWikiDirectedAtChildrenByStaff, $wgAdEngineDisableLateQueue;

		$vars = [];

		$variablesToExpose = [
			'wgEnableAdsInContent' => $wgEnableAdsInContent,
			'wgEnableAdMeldAPIClient' => $wgEnableAdMeldAPIClient,
			'wgEnableAdMeldAPIClientPixels' => $wgEnableAdMeldAPIClientPixels,
			'wgEnableOpenXSPC' => $wgEnableOpenXSPC,

			// Ad Driver
			'wgAdDriverUseCatParam' => array_search($wgLanguageCode, $wgAdPageLevelCategoryLangs),
			'wgAdPageType' => $wgAdPageType,
			'wgAdDriverUseEbay' => $wgAdDriverUseEbay,
			'wgAdDriverUseSevenOneMedia' => $wgAdDriverUseSevenOneMedia,
			'wgUserShowAds' => $wgUser->getOption('showAds'),
			'wgOutboundScreenRedirectDelay' => $wgOutboundScreenRedirectDelay,
			'wgEnableOutboundScreenExt' => $wgEnableOutboundScreenExt,
			'wgAdDriverTrackState' => $wgAdDriverTrackState,
			'wgEnableRHonDesktop' => $wgEnableRHonDesktop,
			'wgAdDriverForceDirectGptAd' => $wgAdDriverForceDirectGptAd,
			'wgAdDriverForceLiftiumAd' => $wgAdDriverForceLiftiumAd,
			'wgAdVideoTargeting' => $wgAdVideoTargeting,
			'wgAdEngineDisableLateQueue' => $wgAdEngineDisableLateQueue,

			// AdEngine2.js
			'wgLoadAdsInHead' => AdEngine2Service::areAdsInHead(),
			'wgShowAds' => AdEngine2Service::areAdsShowableOnPage(),
			'wgAdsShowableOnPage' => AdEngine2Service::areAdsShowableOnPage(), // not used
			'wgAdDriverStartLiftiumOnLoad' => $wgLiftiumOnLoad,

			// generic type of page: forum/search/article/home/...
			'wikiaPageType' => WikiaPageType::getPageType(),
			'wikiaPageIsHub' => WikiaPageType::isWikiaHub(),
			'wikiaPageIsCorporate' => WikiaPageType::isCorporatePage(),

			// category/hub
			'cscoreCat' => HubService::getComscoreCategory($wgCityId)->cat_name,

			// Krux
			'wgEnableKruxTargeting' => $wgEnableKruxTargeting,
			'wgUsePostScribe' => $wgRequest->getBool('usepostscribe', false),
			'wgDartCustomKeyValues' => $wgDartCustomKeyValues,
			'wgWikiDirectedAtChildren' => (bool) $wgWikiDirectedAtChildrenByStaff,

			// AdLogicPageParams.js, SevenOneMediaHelper.js, AnalyticsProviderQuantServe.php
			'cityShort' => AdEngine2Service::getCachedCategory()['short'],
		];

		if (!empty($wgEnableKruxTargeting)) {
			$cat = AdEngine2Service::getCachedCategory();
			$variablesToExpose['wgKruxCategoryId'] = WikiFactoryHub::getInstance()->getKruxId($cat['id']);
		}

		if (!empty($wgAdDriverUseSevenOneMedia)) {
			$url = ResourceLoader::makeCustomURL($wgOut, ['wikia.ext.adengine.sevenonemedia'], 'scripts');
			$variablesToExpose['wgAdDriverSevenOneMediaCombinedUrl'] = $url;
			$variablesToExpose['wgAdDriverSevenOneMediaDisableFirePlaces'] = !empty($wgOasisResponsive) && empty($wgOasisResponsiveLimited);
		}

		foreach($variablesToExpose as $varName => $varValue) {
			if ((bool) $varValue === true) {
				$vars[$varName] = $varValue;
			}
		}

		// ad slots container
		$vars['adslots2'] = [];

		// Used to hop by DART ads
		$vars['adDriverLastDARTCallNoAds'] = [];

		// 3rd party code (eg. dart collapse slot template) can force AdDriver2 to respect unusual slot status
		$vars['adDriver2ForcedStatus'] = [];

		return $vars;
	}

	/**
	 * Get names of variables from getJsVariables to expose in top
	 *
	 * @return array
	 */
	private static function getTopJsVariableNames()
	{
		$topVars = [
			'adDriver2ForcedStatus',         // DART creatives
			'adDriverLastDARTCallNoAds',     // TODO: remove var
			'adslots2',                      // AdEngine2_Ad.php
			'wgAdsShowableOnPage',           // TODO: remove var
			'wgEnableKruxTargeting',         // Krux.js
			'wgKruxCategoryId',              // Krux.run.js
			'wgShowAds',                     // analytics_prod.js
			'wgUserShowAds',                 // JWPlayer.class.php
			'wikiaPageIsCorporate',          // analytics_prod.js
			'wikiaPageType',                 // analytics_prod.js
			'cscoreCat',                     // analytics_prod.js
		];
		if (self::areAdsInHead()) {
			$topVars = array_merge($topVars, [
				'cityShort',                     // AdLogicPageParams.js
				'wgAdEngineDisableLateQueue',    // AdConfig2.js
				'wgAdDriverUseSevenOneMedia',    // AdConfig2.js
				'wgAdDriverForceDirectGptAd',    // AdConfig2.js
				'wgAdDriverForceLiftiumAd',      // AdConfig2.js
				'wgAdDriverTrackState',          // SlotTracker.js
				'wgAdDriverUseCatParam',         // AdLogicPageParams.js
				'wgDartCustomKeyValues',         // AdLogicPageParams.js
				'wgEnableRHonDesktop',           // AdEngine2.run.js
				'wgHighValueCountries',          // AdLogicHighValueCountry.js
				'wgLoadAdsInHead',               // AdEngine2.run.js
				'wgUsePostScribe',               // AdEngine2.run.js, scriptwriter.js
				'wgWikiDirectedAtChildren',      // AdLogicPageParams.js
				'wikiaPageIsHub',                // AdLogicPageParams.js
			]);
		}
		return $topVars;
	}

	/**
	 * Get variables to expose in top of HTML
	 *
	 * @return array
	 */
	public static function getTopJsVariables()
	{
		$allVars = self::getJsVariables();
		$topVars = [];

		$keysToInclude = self::getTopJsVariableNames();
		foreach ($keysToInclude as $key) {
			if (isset($allVars[$key])) {
				$topVars[$key] = $allVars[$key];
			}
		}
		return $topVars;
	}

	/**
	 * Get variables to expose in bottom of HTML
	 *
	 * @return array
	 */
	public static function getBottomJsVariables()
	{
		// Remember in PHP this actually makes an array copy:
		$bottomVars = self::getJsVariables();

		$keysToExclude = self::getTopJsVariableNames();
		foreach ($keysToExclude as $key) {
			unset($bottomVars[$key]);
		}

		return $bottomVars;
	}
}
