<?php

/**
 * AdEngine II Hooks
 */
class AdEngine2Service {

	const ASSET_GROUP_CORE = 'oasis_shared_core_js';
	const ASSET_GROUP_ADENGINE = 'adengine2_js';
	const ASSET_GROUP_LIFTIUM = 'liftium_ads_js';

	const AD_LEVEL_NONE = 'none';           // show no ads
	const AD_LEVEL_LIMITED = 'limited';     // show some ads (logged in users on main page)
	const AD_LEVEL_CORPORATE = 'corporate'; // show some ads (anonymous users on corporate pages)
	const AD_LEVEL_ALL = 'all';

	const cacheKeyVersion = "2.03a";
	const cacheTimeout = 1800;
	/**
	 * Get ad level for the current page. Take into account type of the page and user status.
	 * Return one of the AD_LEVEL_* const
	 *
	 * @return string
	 */
	public static function getAdLevelForPage()
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
			$pageLevel = AdEngine2Service::AD_LEVEL_NONE;
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
			$pageLevel = AdEngine2Service::AD_LEVEL_NONE;
			return $pageLevel;
		}

		$user = $wg->User;
		if (!$user->isLoggedIn() || $user->getOption('showAds')) {
			// Only leaderboard, medrec and invisible on corporate sites for anonymous users
			if ($wg->EnableWikiaHomePageExt) {
				$pageLevel = AdEngine2Service::AD_LEVEL_CORPORATE;
				return $pageLevel;
			}

			// All ads everywhere else
			$pageLevel = AdEngine2Service::AD_LEVEL_ALL;
			return $pageLevel;
		}

		// Logged in users get some ads on the main pages (except on the corporate sites)
		if (!$wg->EnableWikiaHomePageExt && WikiaPageType::isMainPage()) {
			$pageLevel = AdEngine2Service::AD_LEVEL_LIMITED;
			return $pageLevel;
		}

		// Override ad level for a (set of) specific page(s)
		// Use case: sponsor ads on a landing page targeted to Wikia editors (=logged in)
		if ($wg->Title &&
			!empty($wg->PagesWithNoAdsForLoggedInUsersOverriden) &&
			in_array($wg->Title->getDBkey(), $wg->PagesWithNoAdsForLoggedInUsersOverriden)
		) {
			$pageLevel = AdEngine2Service::AD_LEVEL_CORPORATE;
			if (!empty($wg->PagesWithNoAdsForLoggedInUsersOverriden_AD_LEVEL) &&
				in_array($wg->PagesWithNoAdsForLoggedInUsersOverriden_AD_LEVEL, array(
					AdEngine2Service::AD_LEVEL_NONE, AdEngine2Service::AD_LEVEL_LIMITED, AdEngine2Service::AD_LEVEL_CORPORATE, AdEngine2Service::AD_LEVEL_ALL
				))
			) {
				$pageLevel = $wg->PagesWithNoAdsForLoggedInUsersOverriden_AD_LEVEL;
			}
			return $pageLevel;
		}

		// And no other ads
		$pageLevel = AdEngine2Service::AD_LEVEL_NONE;
		return $pageLevel;
	}

	public static function getAdLevelForSlot($slotname)
	{
		if ($slotname === 'INVISIBLE_1' || $slotname === 'INVISIBLE_SKIN') {
			return AdEngine2Service::AD_LEVEL_CORPORATE;
		}

		if (preg_match('/TOP_LEADERBOARD|TOP_RIGHT_BOXAD|GPT_FLUSH|SEVENONEMEDIA_FLUSH/', $slotname)) {
			return AdEngine2Service::AD_LEVEL_LIMITED;
		}
		return AdEngine2Service::AD_LEVEL_ALL;
	}

	public static function compareAdLevels($level1, $level2)
	{
		if ($level1 === $level2) {
			return 0;
		}
		if ($level1 === AdEngine2Service::AD_LEVEL_NONE || $level2 === AdEngine2Service::AD_LEVEL_ALL) {
			// $level1 < $level2
			return -1;
		}
		if ($level1 === AdEngine2Service::AD_LEVEL_ALL || $level2 === AdEngine2Service::AD_LEVEL_NONE) {
			// $level1 > $level2
			return 1;
		}
		if ($level1 === AdEngine2Service::AD_LEVEL_LIMITED) {
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
	public static function areAdsShowableOnPage()
	{
		return (self::getAdLevelForPage() !== AdEngine2Service::AD_LEVEL_NONE);
	}

	public static function getAdsInHeadGroup()
	{
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

	public static function areAdsInHead()
	{
		return self::getAdsInHeadGroup() === 1;
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
	} // show all ads


}
