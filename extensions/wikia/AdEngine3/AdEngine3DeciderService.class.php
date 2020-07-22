<?php
/**
 * Class AdEngine3DeciderService
 *
 * Globals used: F::app()->checkSkin, F::app()->wg, WikiaPageType
 */
class AdEngine3DeciderService {
	/**
	 * @var WikiaGlobalRegistry
	 */
	private $wg;

	/**
	 * @var WikiaApp
	 */
	private $app;

	/**
	 * @var array
	 */
	private $possibleReasons = [];

	const REASON_ACTION_PAGE = 'action_page';
	const REASON_NOEXTERNALS_QUERYSTRING = 'noexternals_querystring';
	const REASON_NOEXTERNALS_WIKIFACTORY = 'noexternals_wikifactory';
	const REASON_NOADS_QUERYSTRING = 'noads_querystring';
	const REASON_NOADS_WIKIFACTORY = 'noads_wikifactory';
	const REASON_WRONG_SKIN = 'wrong_skin';
	const REASON_NO_ADS_PAGE = 'no_ads_page';
	const REASON_NO_ADS_USER = 'no_ads_user';

	public function __construct() {
		$this->app = F::app();
		$this->wg = F::app()->wg;
		$this->possibleReasons = [
			self::REASON_ACTION_PAGE => WikiaPageType::isActionPage(),
			self::REASON_NOEXTERNALS_QUERYSTRING => $this->wg->Request->getBool( 'noexternals', false ),
			self::REASON_NOEXTERNALS_WIKIFACTORY => $this->wg->NoExternals,
			self::REASON_NOADS_QUERYSTRING => $this->wg->Request->getBool( 'noads', false ),
			self::REASON_NOADS_WIKIFACTORY => $this->wg->ShowAds === false,
			self::REASON_WRONG_SKIN => !$this->app->checkSkin( [ 'oasis', 'wikiamobile' ] ),
			self::REASON_NO_ADS_PAGE => $this->isThisPageWithoutAds(),
			self::REASON_NO_ADS_USER => !$this->doesUserAllowAds(),
		];
	}

	private function isThisPageWithoutAds() {
		$runAds = WikiaPageType::isFilePage()
			|| WikiaPageType::isForum()
			|| WikiaPageType::isSearch()
			|| WikiaPageType::isWikiaHub();

		$title = $this->wg->Title;
		if ( $title &&
			!empty( $this->wg->AdDriverPagesWithoutAds ) &&
			in_array( $title->getPrefixedDBKey(), $this->wg->AdDriverPagesWithoutAds )
		) {
			return true;
		}

		if ( !$runAds ) {
			if ( $title ) {
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

		return !$runAds;
	}

	private function doesUserAllowAds() {
		$user = $this->wg->User;
		return !$user->isLoggedIn() || $user->getGlobalPreference( 'showAds' );
	}

	public function getNoAdsReason() {
		$reasons = array_filter($this->possibleReasons, function ($status) {
			return $status;
		});
		$reasons = array_keys($reasons);

		if ( !empty($reasons) ) {
			return array_shift($reasons);
		}

		return null;
	}
}
