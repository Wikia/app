<?php
/**
 * SkeleSkin wiki header
 * 
 * @author Jakub Olek <bukaj.kelo(at)gmail.com>
 * @authore Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 */
class  SkeleSkinWikiHeaderService extends WikiaService {
	public function index() {
		$themeSettings = F::build('ThemeSettings');
		$settings = $themeSettings->getSettings();

		$this->wikiName = ( !empty( $settings['wordmark-text'] ) ) ? $settings['wordmark-text'] : $this->wg->SiteName;
	}
}
