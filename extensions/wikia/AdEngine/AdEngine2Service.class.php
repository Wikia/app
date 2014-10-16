<?php

class AdEngine2Service
{
	const PAGE_TYPE_NO_ADS = 'no_ads';                   // show no ads
	const PAGE_TYPE_MAPS = 'maps';                       // show only ads on maps
	const PAGE_TYPE_HOMEPAGE_LOGGED = 'homepage_logged'; // show some ads (logged in users on main page)
	const PAGE_TYPE_CORPORATE = 'corporate';             // show some ads (anonymous users on corporate pages)
	const PAGE_TYPE_SEARCH = 'search';                   // show some ads (anonymous on search pages)
	const PAGE_TYPE_ALL_ADS = 'all_ads';                 // show all ads!

	/**
	 * Get page type for the current page (ad-wise).
	 * Take into account type of the page and user status.
	 * Return one of the PAGE_TYPE_* constants
	 *
	 * @return string
	 */
	public static function getPageType() {
		return (new AdEngine2PageTypeService())->getPageType();
	}

	/**
	 * Check if for current page the ads can be displayed or not.
	 *
	 * @return bool
	 */
	public static function areAdsShowableOnPage()
	{
		return (new AdEngine2PageTypeService())->areAdsShowableOnPage();
	}

	public static function shouldLoadLiftium() {
		global $wgAdEngineDisableLateQueue;
		return !$wgAdEngineDisableLateQueue;
	}

	public static function shouldLoadLateQueue() {
		global $wgAdEngineDisableLateQueue;
		return !$wgAdEngineDisableLateQueue;
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

	/**
	 * @deprecated
	 * @return array
	 */
	public static function getCachedCategory()
	{
		global $wgCityId;

		wfProfileIn(__METHOD__);

		$hub = WikiFactoryHub::getInstance();
		$cat = array(
			'id' => $hub->getCategoryId($wgCityId),
			'short' => $hub->getCategoryShort($wgCityId),
		);

		wfProfileOut(__METHOD__);

		return $cat;
	}
}
