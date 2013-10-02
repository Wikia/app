<?php
/**
 * WikiaMobile Naviagation
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class  WikiaMobileNavigationService extends WikiaService {
	/**
	 * @var $navModel NavigationModel
	 */
	private $navModel = null;

	function init(){
		$this->navModel = new NavigationModel();
	}

	public function index() {
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->response->setVal( 'wordmarkText', $settings["wordmark-text"] );
		$this->response->setVal( 'wordmarkType', $settings["wordmark-type"] );
		$this->response->setVal( 'wordmarkFont', $settings["wordmark-font"] );

		if ( $settings["wordmark-type"] == "graphic" ) {
			$this->response->setVal( 'wordmarkUrl', wfReplaceImageServer( $settings['wordmark-image-url'], SassUtil::getCacheBuster() ) );
		} else {
			$this->response->setVal( 'wikiName', ( !empty( $settings['wordmark-text'] ) ) ? $settings['wordmark-text'] : $this->wg->SiteName );
		}
	}

	public function navMenu(){

		$mobileNav =  $this->navModel->parse(
			NavigationModel::TYPE_VARIABLE,
			'wgWikiaMobileGlobalNavigationMenu',
			array(
				$this->wg->maxLevelOneNavElements,
				$this->wg->maxLevelTwoNavElements,
				$this->wg->maxLevelThreeNavElements
			),
			NavigationModel::CACHE_TTL,
			true
		);

		$wikiNav = $this->navModel->getWiki();

		$this->response->setVal( 'wikiNav', array(
			$mobileNav,
			$wikiNav['wiki']
		));

		$blacklist = array();

		foreach ( $this->wg->WikiaMobileNavigationBlacklist as $item ) {
			$title = SpecialPage::getTitleFor( $item );
			$blacklist[] = $title->getLocalURL();
			$blacklist[] = $title->getFullURL();
		}

		$this->response->setVal( 'blacklist', $blacklist );

		// report wiki nav parse errors (BugId:15240)
		$this->response->setVal( 'parseErrors', $this->navModel->getErrors() );
	}
}