<?php
/**
 * WikiaMobile Naviagation
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class  WikiaMobileNavigationService extends WikiaService {
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
}