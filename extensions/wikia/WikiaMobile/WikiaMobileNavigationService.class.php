<?php
/**
 * WikiaMobile Naviagation
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class  WikiaMobileNavigationService extends WikiaService {
	/**
	 * @var $navService WikiNavigationService
	 */
	private $navService = null;

	function init(){
		$this->navService = new WikiNavigationService();
	}

	public function index() {
		/**
		 * @var $themeSettings ThemeSettings
		 */
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

		//$this->response->setVal( 'searchOpen', ($this->wg->Title->getText() == SpecialPage::getTitleFor( 'Search' )->getText() ) );
	}

	public function navMenu(){
		// render global wikia navigation ("On the Wiki" menu)
		$this->response->setVal( 'wikiaMenuNodes',
			$this->navService->parseVariable(
					'wgWikiaMobileGlobalNavigationMenu',
					array(
						$this->wg->maxLevelOneNavElements,
						$this->wg->maxLevelTwoNavElements,
						$this->wg->maxLevelThreeNavElements
					),
					WikiNavigationService::CACHE_TTL,
					true,
					false
				)
		);

		// render local navigation (more tabs)
		$this->response->setVal( 'wikiMenuNodes',
			$this->navService->parseMenu(
				WikiNavigationService::WIKI_LOCAL_MESSAGE,
				array(
					$this->wg->maxLevelOneNavElements,
					$this->wg->maxLevelTwoNavElements,
					$this->wg->maxLevelThreeNavElements
				)
			)
		);

		$blacklist = array();

		foreach ( $this->wg->WikiaMobileNavigationBlacklist as $index => $item ) {
			$title = SpecialPage::getTitleFor( $item );
			$blacklist[] = $title->getLocalURL();
			$blacklist[] = $title->getFullURL();
		}

		$this->response->setVal( 'blacklist', $blacklist );

		// report wiki nav parse errors (BugId:15240)
		$this->response->setVal( 'parseErrors', $this->navService->getErrors() );
	}
}