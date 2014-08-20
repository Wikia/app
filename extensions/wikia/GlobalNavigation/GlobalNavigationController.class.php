<?php

class GlobalNavigationController extends WikiaController {

	const CENTRAL_URL = 'http://www.wikia.com';
	const CENTRAL_LOCAL_URL = '/Wikia';

	public function index() {
		Wikia::addAssetsToOutput( 'global_navigation_scss' );
		Wikia::addAssetsToOutput( 'global_navigation_js' );
		// TODO remove after when Oasis is retired
		Wikia::addAssetsToOutput( 'global_navigation_oasis_scss' );

		$userLang = $this->wg->Lang->getCode();
		// Link to Wikia home page
		$centralUrl = $this->getCentralUrl( true );

		$createWikiUrl = GlobalTitle::newFromText(
			'CreateNewWiki',
			NS_SPECIAL,
			WikiService::WIKIAGLOBAL_CITY_ID
		)->getFullURL();

		if ( $userLang != 'en' ) {
			$createWikiUrl .= '?uselang=' . $userLang;
		}

		$this->response->setVal( 'centralUrl', $centralUrl );
		$this->response->setVal( 'createWikiUrl', $createWikiUrl );
	}

	public function searchVenus() {
		$centralUrl = $this->getCentralUrl();
		$specialSearchTitle = SpecialPage::getTitleFor( 'Search' );
		$localSearchUrl = $specialSearchTitle->getFullUrl();
		$this->response->setVal( 'globalSearchUrl', $centralUrl . $specialSearchTitle->getLocalURL() );
		$this->response->setVal( 'localSearchUrl', $localSearchUrl );
		$this->response->setVal( 'defaultSearchMessage', wfMessage( 'global-navigation-local-search' )->text() );
		$this->response->setVal( 'defaultSearchUrl', $localSearchUrl );
	}

	public function getCentralUrl( $appendLocalUrl = false ) {
		$userLang = $this->wg->Lang->getCode();
		$centralFromLang = $this->wg->LangToCentralMap[$userLang];
		if ( !empty( $centralFromLang ) ) {
			$url = $centralFromLang;
		} else {
			$url = $appendLocalUrl ? self::CENTRAL_URL . self::CENTRAL_LOCAL_URL : self::CENTRAL_URL;
		}
		return $url;
	}
}
