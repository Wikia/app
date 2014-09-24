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
		Wikia::addAssetsToOutput( 'global_navigation_facebook_login_js' );
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
		$globalSearchUrl = $this->getGlobalSearchUrl( $centralUrl, $lang );
		$specialSearchTitle = SpecialPage::getTitleFor( 'Search' );
		$localSearchUrl = $specialSearchTitle->getFullUrl();
		$fulltext = $this->wg->User->getOption('enableGoSearch') ? 0 : 'Search';
		$globalRequest = $this->wg->request;
		$query = $globalRequest->getVal( 'search', $globalRequest->getVal( 'query', '' ) );

		if (WikiaPageType::isCorporatePage() && !WikiaPageType::isWikiaHub()) {
			$this->response->setVal( 'disableLocalSearchOptions', true );
			$this->response->setVal( 'defaultSearchUrl', $globalSearchUrl );
		} else {
			$this->response->setVal( 'globalSearchUrl', $globalSearchUrl );
			$this->response->setVal( 'localSearchUrl', $localSearchUrl );
			$this->response->setVal( 'defaultSearchMessage', wfMessage( 'global-navigation-local-search' )->text() );
			$this->response->setVal( 'defaultSearchUrl', $localSearchUrl );
		}
		$this->response->setVal( 'fulltext', $fulltext );
		$this->response->setVal( 'query', $query );
		$this->response->setVal( 'lang', $lang );
	}

	public function hubsMenu() {
		$menuNodes = $this->getMenuNodes();
		$this->response->setVal('menuNodes', $menuNodes);

		$activeNode = $this->getActiveNode();
		$activeNodeIndex = $this->getActiveNodeIndex($menuNodes, $activeNode);
		$this->response->setVal('activeNodeIndex', $activeNodeIndex);
	}

	public function hubsMenuSections() {
		$menuSections = $this->request->getVal('menuSections', []);
		$this->response->setVal('menuSections', $menuSections);
	}

	public function lazyLoadHubsMenu() {
		$lazyLoadMenuNodes = $this->getMenuNodes();

		$activeNode = $this->getActiveNode();
		$activeNodeIndex = $this->getActiveNodeIndex($lazyLoadMenuNodes, $activeNode);
		array_splice($lazyLoadMenuNodes, $activeNodeIndex, 1);

		$this->response->setVal('menuSections', $lazyLoadMenuNodes);
		$this->overrideTemplate( 'hubsMenuSections' );
	}

	private function getMenuNodes() {
		$menuNodes = (new NavigationModel(true /* useSharedMemcKey */) )->getTree(
			'global-navigation-hubs-menu'
		);

		return $menuNodes;
	}

	private function getActiveNodeIndex( $menuNodes, $activeNode ) {
		$nodeIndex = 0;

		foreach ( $menuNodes as $index => $hub ) {
			if ( $hub['specialAttr'] === $activeNode ) {
				$nodeIndex = $index;
				break;
			}
		}
		return $nodeIndex;
	}

	/**
	 * Get active node in Hamburger menu
	 * Temporary method until we full migrate to new verticals
	 *
	 * @return string
	 */
	private function getActiveNode() {
		global $wgCityId;
		$activeNode = '';

		$wikiFactoryHub = WikiFactoryHub::getInstance();
		$verticalId = $wikiFactoryHub->getVerticalId($wgCityId);

		$allVerticals = $wikiFactoryHub->getAllVerticals();
		if ( isset( $allVerticals[$verticalId]['short'] ) ) {
			$activeNode = $allVerticals[$verticalId]['short'];
		}

		return $activeNode;
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
