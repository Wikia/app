<?php
/**
 * Class NoAdsDeciderService
 *
 * Globals used: F::app()->checkSkin, F::app()->wg, WikiaPageType
 */
class AdsDeciderService {
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
		];
	}

	public function getNoAdsReason() {
		return null;
	}
}
