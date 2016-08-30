<?php

class GlobalNavigationController extends WikiaController {

	// how many hubs should be displayed in the menu
	// if we do not get enough, use transparent background
	// to fill the space (CON-1820)
	const HUBS_COUNT = 7;

	/**
	 * @var GlobalNavigationHelper
	 */
	private $helper;

	/**
	 * @var GlobalNavigationHelper
	 */
	private $wikiaLogoHelper;

	public function __construct() {
		parent::__construct();
		$this->helper = new GlobalNavigationHelper();
		$this->wikiaLogoHelper = new WikiaLogoHelper();
	}

	public function index() {
		global $wgLang, $wgUser;

		Wikia::addAssetsToOutput( 'global_navigation_scss' );
		Wikia::addAssetsToOutput( 'global_navigation_js' );

		$this->response->setVal( 'menuContents', $this->helper->getMenuNodes() );
		$this->response->setVal( 'isFandomExposed', $this->wikiaLogoHelper->isFandomExposed( $wgLang->getCode() ) );

		$createWikiUrl = $this->helper->getCreateNewWikiUrl( $wgLang->getCode() );
		$userCanRead = $wgUser->isAllowed( 'read' );

		$this->response->setVal( 'centralUrl', $this->wikiaLogoHelper->getMainCorpPageURL() );
		$this->response->setVal( 'createWikiUrl', $createWikiUrl );
		$this->response->setVal( 'notificationsEnabled', !empty( $userCanRead ) );
		$this->response->setVal( 'isAnon', $wgUser->isAnon() );
	}

	public function searchIndex() {
		global $wgRequest, $wgSitename, $wgUser;

		$lang = $this->helper->getLangForSearchResults();

		$centralUrl = $this->helper->getCentralUrlFromGlobalTitle( $lang );
		$globalSearchUrl = $this->helper->getGlobalSearchUrl( $centralUrl );
		$localSearchUrl = SpecialPage::getTitleFor( 'Search' )->getFullUrl();
		$fulltext = $wgUser->getGlobalPreference( 'enableGoSearch' ) ? 0 : 'Search';
		$query = $wgRequest->getVal( 'search', $wgRequest->getVal( 'query', '' ) );
		$localSearchPlaceholder = html_entity_decode(
			wfMessage( 'global-navigation-search-wikia', $wgSitename )->parse()
		);
		if ( WikiaPageType::isCorporatePage() && !WikiaPageType::isWikiaHub() ) {
			$this->response->setVal( 'disableLocalSearchOptions', true );
			$this->response->setVal( 'defaultSearchPlaceholder', wfMessage( 'global-navigation-global-search' )->escaped() );
			$this->response->setVal( 'defaultSearchUrl', $globalSearchUrl );
		} else {
			$this->response->setVal( 'globalSearchUrl', $globalSearchUrl );
			$this->response->setVal( 'localSearchUrl', $localSearchUrl );
			$this->response->setVal( 'localSearchPlaceholder', $localSearchPlaceholder );
			$this->response->setVal( 'defaultSearchPlaceholder',  $localSearchPlaceholder );
			$this->response->setVal( 'defaultSearchUrl', $localSearchUrl );
		}

		$this->response->setVal( 'fulltext', $fulltext );
		$this->response->setVal( 'query', $query );
		$this->response->setVal( 'lang', $lang );
	}
}
