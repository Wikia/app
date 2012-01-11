<?php
/**
 * WikiaMobile Naviagation
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class  WikiaMobileNavigationService extends WikiaService {
	private $navService = null;

	function init(){
		$this->navService = F::build( 'WikiNavigationService' );
	}

	public function index() {
		$themeSettings = F::build('ThemeSettings');
		$settings = $themeSettings->getSettings();

		$this->response->setVal( 'wordmarkText', $settings["wordmark-text"] );
		$this->response->setVal( 'wordmarkType', $settings["wordmark-type"] );
		$this->response->setVal( 'wordmarkFont', $settings["wordmark-font"] );

		if ( $settings["wordmark-type"] == "graphic" ) {
			$this->response->setVal( 'wordmarkUrl', wfReplaceImageServer( $settings['wordmark-image-url'], SassUtil::getCacheBuster() ) );
		} else {
			$this->response->setVal( 'wikiName', ( !empty( $settings['wordmark-text'] ) ) ? $settings['wordmark-text'] : $this->wg->SiteName );
		}

		$this->response->setVal( 'searchOpen', ($this->wg->Title->getText() == SpecialPage::getTitleFor( 'Search' )->getText() ) );
	}

	public function navMenu(){
		// render global wikia navigation ("On the Wiki" menu)
		$this->response->setVal( 'wikiaMenuNodes',
			$this->navService->parseMenu(
				WikiNavigationService::WIKIA_GLOBAL_VARIABLE,
				array(
					1,
					$this->wg->maxLevelTwoNavElements,
					$this->wg->maxLevelThreeNavElements
				),
				true
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

		// report wiki nav parse errors (BugId:15240)
		$this->response->setVal( 'parseErrors', $this->navService->getErrors() );
	}
}