<?php

class GlobalNavigationController extends WikiaController {

	const CENTRAL_URL = 'http://www.wikia.com';
	const CENTRAL_LOCAL_URL = '/Wikia';
	const USE_LANG_PARAMETER = '?uselang=';

	public function index() {
		Wikia::addAssetsToOutput( 'global_navigation_scss' );
		Wikia::addAssetsToOutput( 'global_navigation_js' );
		// TODO remove after when Oasis is retired
		Wikia::addAssetsToOutput( 'global_navigation_oasis_scss' );

		$userLang = $this->wg->Lang->getCode();
		// Link to Wikia home page
		$centralUrl = $this->getCentralUrl( $userLang, true );

		$createWikiUrl = $this->getCreateNewWikiUrl( $userLang );

		$this->response->setVal( 'centralUrl', $centralUrl );
		$this->response->setVal( 'createWikiUrl', $createWikiUrl );
	}

	public function searchIndex() {
		$lang = $this->wg->Lang->getCode();
		$centralUrl = $this->getCentralUrl( $lang );
		$specialSearchTitle = SpecialPage::getTitleFor( 'Search' );
		$localSearchUrl = $specialSearchTitle->getFullUrl();

		$this->response->setVal( 'globalSearchUrl', $centralUrl . $specialSearchTitle->getLocalURL() );
		$this->response->setVal( 'localSearchUrl', $localSearchUrl );
		$this->response->setVal( 'defaultSearchMessage', wfMessage( 'global-navigation-local-search' )->text() );
		$this->response->setVal( 'defaultSearchUrl', $localSearchUrl );
	}

	public function getCentralUrl( $lang, $appendLocalUrl = false ) {
		$langToCentralMap = $this->wg->LangToCentralMap;
		if ( !empty( $langToCentralMap[$lang] ) ) {
			$url = $langToCentralMap[$lang];
		} else {
			$url = $appendLocalUrl ? self::CENTRAL_URL . self::CENTRAL_LOCAL_URL : self::CENTRAL_URL;
			if ( $lang != 'en' ) {
				$url .= self::USE_LANG_PARAMETER . $lang;
			}
		}
		return $url;
	}

	public function getCreateNewWikiUrl( $lang ) {
		$createWikiUrl = GlobalTitle::newFromText(
			'CreateNewWiki',
			NS_SPECIAL,
			WikiService::WIKIAGLOBAL_CITY_ID
		)->getFullURL();

		if ( $lang != 'en' ) {
			$createWikiUrl .= self::USE_LANG_PARAMETER . $lang;
		}
		return $createWikiUrl;
	}
}
