<?php

class GlobalNavigationController extends WikiaController {

	const DEFAULT_LANG = 'en';
	const USE_LANG_PARAMETER = '?uselang=';
	const CENTRAL_WIKI_SEARCH = '/wiki/Special:Search';

	/**
	 * @var WikiaCorporateModel
	 */
	private $wikiCorporateModel;

	public function __construct() {
		parent::__construct();
		$this->wikiCorporateModel = new WikiaCorporateModel();
	}

	public function index() {
		Wikia::addAssetsToOutput( 'global_navigation_scss' );
		Wikia::addAssetsToOutput( 'global_navigation_js' );
		// TODO remove after when Oasis is retired
		Wikia::addAssetsToOutput( 'global_navigation_oasis_scss' );

		$userLang = $this->wg->Lang->getCode();
		// Link to Wikia home page
		$centralUrl = $this->getCentralUrlForLang( $userLang, true );

		$createWikiUrl = $this->getCreateNewWikiUrl( $userLang );

		$this->response->setVal( 'centralUrl', $centralUrl );
		$this->response->setVal( 'createWikiUrl', $createWikiUrl );
	}

	public function searchIndex() {
		$lang = $this->wg->Lang->getCode();
		$centralUrl = $this->getCentralUrlForLang( $lang, false );
		$specialSearchTitle = SpecialPage::getTitleFor( 'Search' );
		$localSearchUrl = $specialSearchTitle->getFullUrl();
		$this->response->setVal( 'globalSearchUrl', $this->getGlobalSearchUrl( $centralUrl, $lang ) );
		$this->response->setVal( 'localSearchUrl', $localSearchUrl );
		$this->response->setVal( 'defaultSearchMessage', wfMessage( 'global-navigation-local-search' )->text() );
		$this->response->setVal( 'defaultSearchUrl', $localSearchUrl );
		$this->response->setVal( 'lang', $lang );
	}

	public function getCentralUrlForLang( $lang, $fullUrl ) {
		$centralWikiExists = $this->centralWikiInLangExists( $lang );
		if ( $centralWikiExists ) {
			$title = $this->getCentralWikiTitleForLang( $lang );
		} else {
			$title = $this->getCentralWikiTitleForLang( self::DEFAULT_LANG );
		}

		if ( $fullUrl ) {
			$url = $title->getFullURL();
			if ( !$centralWikiExists && $lang != self::DEFAULT_LANG ) {
				$url .= self::USE_LANG_PARAMETER . $lang;
			}
		} else {
			$url = $title->getServer();
		}
		return $url;
	}

	public function getCreateNewWikiUrl( $lang ) {
		$createWikiUrl = $this->getCreateNewWikiFullUrl();

		if ( $lang != self::DEFAULT_LANG ) {
			$createWikiUrl .= self::USE_LANG_PARAMETER . $lang;
		}
		return $createWikiUrl;
	}

	public function getGlobalSearchUrl( $centralUrl, $lang ) {
		if ( $lang != self::DEFAULT_LANG && !$this->centralWikiInLangExists( $lang ) ) {
			return $centralUrl . self::CENTRAL_WIKI_SEARCH;
		} else {
			$specialSearchTitle = $this->getTitleForSearch();
			return $centralUrl . $specialSearchTitle;
		}
	}

	protected function centralWikiInLangExists( $lang ) {
		try {
			GlobalTitle::newMainPage( $this->wikiCorporateModel->getCorporateWikiIdByLang( $lang ) );
		} catch ( Exception $ex ) {
			return false;
		}
		return true;
	}

	protected function getCreateNewWikiFullUrl() {
		return GlobalTitle::newFromText(
			'CreateNewWiki',
			NS_SPECIAL,
			WikiService::WIKIAGLOBAL_CITY_ID
		)->getFullURL();
	}

	protected function getCentralWikiTitleForLang( $lang ) {
		return GlobalTitle::newMainPage( $this->wikiCorporateModel->getCorporateWikiIdByLang( $lang ) );
	}

	protected function getTitleForSearch() {
		return SpecialPage::getTitleFor( 'Search' )->getLocalURL();
	}

}
