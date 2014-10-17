<?php

class AdEngine2Service
{

	const PAGE_TYPE_NO_ADS = 'no_ads';                   // show no ads
	const PAGE_TYPE_MAPS = 'maps';                       // show only ads on maps
	const PAGE_TYPE_HOMEPAGE_LOGGED = 'homepage_logged'; // show some ads (logged in users on main page)
	const PAGE_TYPE_CORPORATE = 'corporate';             // show some ads (anonymous users on corporate pages)
	const PAGE_TYPE_SEARCH = 'search';                   // show some ads (anonymous on search pages)
	const PAGE_TYPE_ALL_ADS = 'all_ads';                 // show all ads!

	const cacheKeyVersion = "2.03a";
	const cacheTimeout = 1800;

	/**
	 * Get page type for the current page (ad-wise).
	 * Take into account type of the page and user status.
	 * Return one of the PAGE_TYPE_* constants
	 *
	 * @return string
	 */
	public static function getPageType()
	{
		$wg = F::app()->wg;
		$title = null;

		static $pageLevel = null;

		if ($pageLevel) {
			return $pageLevel;
		}

		if (WikiaPageType::isActionPage()
			|| $wg->Request->getBool('noexternals', $wg->NoExternals)
			|| $wg->Request->getBool('noads', false)
			|| $wg->ShowAds === false
			|| $wg->EnableAdEngineExt === false
			|| !F::app()->checkSkin(['oasis', 'wikiamobile', 'venus'])
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
					|| $title->isSpecial('Leaderboard')
					|| $title->isSpecial('Maps');
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

			if (WikiaPageType::isSearch()) {
				$pageLevel = self::PAGE_TYPE_SEARCH;
				return $pageLevel;
			}

			if ($title && $title->isSpecial('Maps')) {
				$pageLevel = self::PAGE_TYPE_MAPS;
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
		if ($title &&
			!empty($wg->PagesWithNoAdsForLoggedInUsersOverriden) &&
			in_array($title->getDBkey(), $wg->PagesWithNoAdsForLoggedInUsersOverriden)
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
		global $wgAdEngineDisableLateQueue;
		return !$wgAdEngineDisableLateQueue;
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

	public static function areAdsAfterPageLoad()
	{
		global $wgLoadLateAdsAfterPageLoad;
		return $wgLoadLateAdsAfterPageLoad;
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
	 * Get variables to expose in top of HTML
	 *
	 * @return array
	 */
	public static function getTopJsVariables()
	{
		global $wgCityId, $wgEnableAdsInContent, $wgEnableOpenXSPC,
			$wgUser, $wgEnableAdMeldAPIClient, $wgEnableAdMeldAPIClientPixels,
			$wgOutboundScreenRedirectDelay, $wgEnableOutboundScreenExt,
			$wgAdDriverUseSevenOneMedia, $wgAdDriverUseDartForSlotsBelowTheFold,
			$wgAdPageLevelCategoryLangs, $wgLanguageCode, $wgAdDriverTrackState,
			$wgAdDriverForceDirectGptAd, $wgAdDriverForceLiftiumAd,
			$wgOasisResponsive, $wgOasisResponsiveLimited,
			$wgAdDriverUseRemnantGpt, $wgOut,
			$wgRequest, $wgEnableKruxTargeting, $wgAdDriverRubiconCachedOnly,
			$wgAdVideoTargeting, $wgLiftiumOnLoad, $wgAdDriverSevenOneMediaOverrideSub2Site,
			$wgDartCustomKeyValues, $wgWikiDirectedAtChildrenByStaff,
			$wgWikiDirectedAtChildrenByFounder, $wgAdEngineDisableLateQueue,
			$wgAdDriverUseBottomLeaderboard, $wgAdDriverBottomLeaderboardImpressionCapping,
			$wgAdDriverEnableAdsInMaps, $wgAdDriverWikiIsTop1000, $wgAdDriverUseTaboola,
			$wgAdDriverUseAdsAfterInfobox;

		$vars = [];

		$variablesToExpose = [
			'wgEnableAdsInContent' => $wgEnableAdsInContent,
			'wgEnableAdMeldAPIClient' => $wgEnableAdMeldAPIClient,
			'wgEnableAdMeldAPIClientPixels' => $wgEnableAdMeldAPIClientPixels,
			'wgEnableOpenXSPC' => $wgEnableOpenXSPC,

			// AdConfigMobile.js
			'adEnginePageType' => self::getPageType(),

			// Ad Driver
			'wgAdDriverUseAdsAfterInfobox' => $wgAdDriverUseAdsAfterInfobox,
			'wgAdDriverUseCatParam' => array_search($wgLanguageCode, $wgAdPageLevelCategoryLangs),
			'wgAdDriverUseDartForSlotsBelowTheFold' => $wgAdDriverUseDartForSlotsBelowTheFold === null ? 'hub' : $wgAdDriverUseDartForSlotsBelowTheFold,
			'wgAdDriverUseRemnantGpt' => $wgAdDriverUseRemnantGpt,
			'wgAdDriverUseSevenOneMedia' => $wgAdDriverUseSevenOneMedia,
			'wgAdDriverUseTaboola' => $wgAdDriverUseTaboola,
			'wgAdDriverRubiconCachedOnly' => $wgAdDriverRubiconCachedOnly,
			'wgAdDriverSevenOneMediaOverrideSub2Site' => $wgAdDriverSevenOneMediaOverrideSub2Site,
			'wgUserShowAds' => $wgUser->getOption('showAds'),
			'wgOutboundScreenRedirectDelay' => $wgOutboundScreenRedirectDelay,
			'wgEnableOutboundScreenExt' => $wgEnableOutboundScreenExt,
			'wgAdDriverTrackState' => $wgAdDriverTrackState,
			'wgAdDriverForceDirectGptAd' => $wgAdDriverForceDirectGptAd,
			'wgAdDriverForceLiftiumAd' => $wgAdDriverForceLiftiumAd,
			'wgAdVideoTargeting' => $wgAdVideoTargeting,
			'wgAdEngineDisableLateQueue' => $wgAdEngineDisableLateQueue,

			// AdEngine2.js
			'wgLoadAdsInHead' => AdEngine2Service::areAdsInHead(),
			'wgLoadLateAdsAfterPageLoad' => AdEngine2Service::areAdsAfterPageLoad(),
			'wgShowAds' => AdEngine2Service::areAdsShowableOnPage(),
			'wgAdsShowableOnPage' => AdEngine2Service::areAdsShowableOnPage(), // not used
			'wgAdDriverStartLiftiumOnLoad' => $wgLiftiumOnLoad,

			// generic type of page: forum/search/article/home/...
			'wikiaPageType' => WikiaPageType::getPageType(),
			'wikiaPageIsHub' => WikiaPageType::isWikiaHub(),
			'wikiaPageIsCorporate' => WikiaPageType::isCorporatePage(),

			// category/hub
			'cscoreCat' => HubService::getCategoryInfoForCity($wgCityId)->cat_name,

			// Krux
			'wgEnableKruxTargeting' => $wgEnableKruxTargeting,
			'wgUsePostScribe' => $wgRequest->getBool('usepostscribe', false),
			'wgWikiDirectedAtChildren' => $wgWikiDirectedAtChildrenByStaff || $wgWikiDirectedAtChildrenByFounder,

			// AdLogicPageParams.js, SevenOneMediaHelper.js, AnalyticsProviderQuantServe.php
			'cityShort' => AdEngine2Service::getCachedCategory()['short'],
			'wgDartCustomKeyValues' => $wgDartCustomKeyValues,
			'wgAdDriverWikiIsTop1000' => $wgAdDriverWikiIsTop1000,

			// intMapPontoBridge.js
			'wgAdDriverEnableAdsInMaps' => $wgAdDriverEnableAdsInMaps,
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

		if ($wgAdDriverUseBottomLeaderboard) {
			$variablesToExpose['wgAdDriverBottomLeaderboardImpressionCapping'] = $wgAdDriverBottomLeaderboardImpressionCapping;
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
}
