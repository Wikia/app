<?php
/**
 * Class NoAdsDeciderService
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
	private $reasons = [];

	public function __construct() {
		$this->app = F::app();
		$this->wg = F::app()->wg;
		$this->reasons = [
			'action_page' => WikiaPageType::isActionPage(),
			'noexternals_querystring' => $this->wg->Request->getBool( 'noexternals', false ),
			'noexternals_wikifactory' => $this->wg->NoExternals,
			'noads_querystring' => $this->wg->Request->getBool( 'noads', false ),
			'noads_wikifactory' => $this->wg->ShowAds === false,
			'wrong_skin' => !$this->app->checkSkin( [ 'oasis', 'wikiamobile' ] ),
			'no_ads_page' => $this->isThisPageWithoutAds(),
			'no_ads_user' => !$this->doesUserAllowAds()
		];
	}

	private function isThisPageWithoutAds() {
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
			return false;
		}

		return true;
	}

	private function doesUserAllowAds() {
		$user = $this->wg->User;
		return !$user->isLoggedIn() || $user->getGlobalPreference( 'showAds' );
	}

	public function getNoAdsReason() {
		return null;
	}
}
