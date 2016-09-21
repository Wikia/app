<?php

/**
 * Class AdEngine2PageTypeService
 *
 * Globals used: F::app()->checkSkin, F::app()->wg, WikiaPageType
 */
class AdEngine2PageTypeService {
	/**
	 * @var WikiaGlobalRegistry
	 */
	private $wg;

	/**
	 * @var WikiaApp
	 */
	private $app;

	const PAGE_TYPE_NO_ADS = 'no_ads';                   // show no ads
	const PAGE_TYPE_MAPS = 'maps';                       // show only ads on maps
	const PAGE_TYPE_HOMEPAGE_LOGGED = 'homepage_logged'; // show some ads (logged in users on main page)
	const PAGE_TYPE_CORPORATE = 'corporate';             // show some ads (anonymous users on corporate pages)
	const PAGE_TYPE_SEARCH = 'search';                   // show some ads (anonymous on search pages)
	const PAGE_TYPE_ALL_ADS = 'all_ads';                 // show all ads!

	public function __construct() {
		$this->app = F::app();
		$this->wg = F::app()->wg;
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

		if ( WikiaPageType::isActionPage()
			|| $this->wg->Request->getBool( 'noexternals', $this->wg->NoExternals )
			|| $this->wg->Request->getBool( 'noads', false )
			|| $this->wg->ShowAds === false
			|| !$this->app->checkSkin( [ 'oasis', 'wikiamobile' ] )
		) {
			$pageLevel = self::PAGE_TYPE_NO_ADS;
			return $pageLevel;
		}

		$runAds = WikiaPageType::isFilePage()
			|| WikiaPageType::isForum()
			|| WikiaPageType::isSearch()
			|| WikiaPageType::isWikiaHub();

		if ( !$runAds ) {
			if ( $this->wg->Title ) {
				$title = $this->wg->Title;
				$namespace = $title->getNamespace();
				$runAds = in_array( $namespace, $this->wg->ContentNamespaces )
					|| isset( $this->wg->ExtraNamespaces[$namespace] )

					// Blogs:
					|| BodyController::isBlogListing()
					|| BodyController::isBlogPost()

					// Quiz, category and project pages:
					|| ( defined( 'NS_WIKIA_PLAYQUIZ' ) && $title->inNamespace( NS_WIKIA_PLAYQUIZ ) )
					|| ( defined( 'NS_CATEGORY' ) && $namespace == NS_CATEGORY )
					|| ( defined( 'NS_PROJECT' ) && $namespace == NS_PROJECT )

					// Chosen special pages:
					|| $title->isSpecial( 'Leaderboard' )
					|| $title->isSpecial( 'Maps' )
					|| $title->isSpecial( 'Images' )
					|| $title->isSpecial( 'Videos' );
			}
		}

		if ( !$runAds ) {
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
