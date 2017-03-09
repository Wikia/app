<?php

class PremiumPageHeaderController extends WikiaController {

	public function wikiHeader() {
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->setVal( 'wordmarkText', $settings["wordmark-text"] );

		$this->setVal( 'tallyMsg',
			wfMessage( 'pph-total-articles', SiteStats::articles() )->parse() );

		$this->setVal( 'addNewPageHref', SpecialPage::getTitleFor( 'CreatePage' )->getLocalURL() );

		$this->setVal( 'mainPageURL', Title::newMainPage()->getLocalURL() );

	}

	public function navigation() {
		$this->setVal( 'data',
			( new NavigationModel() )->getLocalNavigationTree( NavigationModel::WIKI_LOCAL_MESSAGE ) );
	}

	public function articleHeader() {
		$skinVars= $this->app->getSkinTemplateObj()->data;
		$this->setVal('displaytitle', $skinVars['displaytitle']);
		$this->setVal('title', $skinVars['title']);
	}
}
