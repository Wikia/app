<?php

/**
 * Class AdEngine3PageTypeService
 *
 * Globals used: F::app()->checkSkin, F::app()->wg, WikiaPageType
 */
class AdEngine3PageTypeService {
	/**
	 * @var WikiaGlobalRegistry
	 */
	private $wg;

	/**
	 * @var WikiaApp
	 */
	private $app;

	/**
	 * @var AdEngine3DeciderService
	 */
	private $adsDecider;

	const PAGE_TYPE_NO_ADS = 'no_ads';                   // show no ads
	const PAGE_TYPE_MAPS = 'maps';                       // show only ads on maps
	const PAGE_TYPE_HOMEPAGE_LOGGED = 'homepage_logged'; // show some ads (logged in users on main page)
	const PAGE_TYPE_CORPORATE = 'corporate';             // show some ads (anonymous users on corporate pages)
	const PAGE_TYPE_SEARCH = 'search';                   // show some ads (anonymous on search pages)
	const PAGE_TYPE_ALL_ADS = 'all_ads';                 // show all ads!

	public function __construct(AdEngine3DeciderService $adsDecider) {
		$this->app = F::app();
		$this->wg = F::app()->wg;
		$this->adsDecider = $adsDecider;
	}

	/**
	 * Get page type for the current page (ad-wise).
	 * Take into account type of the page and user status.
	 * Return one of the PAGE_TYPE_* constants
	 *
	 * @return string
	 */
	public function getPageType() {
		$title = null;
		$noAdsReason = $this->adsDecider->getNoAdsReason();

		if ( $noAdsReason !== null && $noAdsReason !== 'no_ads_user' ) {
		// no_ads_users may still get ads on special pages - the logic is below
			$pageLevel = self::PAGE_TYPE_NO_ADS;
			return $pageLevel;
		}

		$user = $this->wg->User;
		if ( !$user->isLoggedIn() || $user->getGlobalPreference( 'showAds' ) ) {
			// Only leaderboard, medrec and invisible on corporate sites for anonymous users
			if ( WikiaPageType::isCorporatePage() ) {
				$pageLevel = self::PAGE_TYPE_CORPORATE;
				return $pageLevel;
			}

			if ( WikiaPageType::isSearch() ) {
				$pageLevel = self::PAGE_TYPE_SEARCH;
				return $pageLevel;
			}

			if ( $title && $title->isSpecial( 'Maps' ) ) {
				$pageLevel = self::PAGE_TYPE_MAPS;
				return $pageLevel;
			}

			// All ads everywhere else
			$pageLevel = self::PAGE_TYPE_ALL_ADS;
			return $pageLevel;
		}

		// Logged in users get some ads on the main pages (except on the corporate sites)
		if ( !WikiaPageType::isCorporatePage() && WikiaPageType::isMainPage() ) {
			$pageLevel = self::PAGE_TYPE_HOMEPAGE_LOGGED;
			return $pageLevel;
		}

		// Override ad level for a (set of) specific page(s)
		// Use case: sponsor ads on a landing page targeted to Wikia editors (=logged in)
		if ( $title &&
			!empty( $this->wg->PagesWithNoAdsForLoggedInUsersOverriden ) &&
			in_array( $title->getDBkey(), $this->wg->PagesWithNoAdsForLoggedInUsersOverriden )
		) {
			$pageLevel = self::PAGE_TYPE_CORPORATE;
			return $pageLevel;
		}

		// And no other ads
		$pageLevel = self::PAGE_TYPE_NO_ADS;
		return $pageLevel;
	}

	/**
	 * Check if for current page the ads can be displayed or not.
	 *
	 * @return bool
	 */
	public function areAdsShowableOnPage() {
		return ( $this->getPageType() !== self::PAGE_TYPE_NO_ADS );
	}
}
