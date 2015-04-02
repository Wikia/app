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
		Wikia::addAssetsToOutput( 'global_navigation_facebook_login_js' );
		// TODO remove after when Oasis is retired
		Wikia::addAssetsToOutput( 'global_navigation_oasis_scss' );

		//Lang for centralUrl and CNW should be the same as user language not content language
		//That's why $wgLang global is used
		$lang = $wgLang->getCode();
		$centralUrl = $this->wikiaLogoHelper->getCentralUrlForLang( $lang );
		$createWikiUrl = $this->helper->getCreateNewWikiUrl( $lang );
		$userCanRead = $wgUser->isAllowed( 'read' );

		$this->response->setVal( 'centralUrl', $centralUrl );
		$this->response->setVal( 'createWikiUrl', $createWikiUrl );
		$this->response->setVal( 'notificationsEnabled', !empty($userCanRead));
		$this->response->setVal( 'isAnon', $wgUser->isAnon());

		$isGameStarLogoEnabled = $this->isGameStarLogoEnabled();
		$this->response->setVal( 'isGameStarLogoEnabled', $isGameStarLogoEnabled );
		if ( $isGameStarLogoEnabled ) {
			$this->response->addAsset( 'extensions/wikia/GlobalNavigation/styles/GlobalNavigationGameStar.scss' );
		}
	}

	public function searchIndex() {
		global $wgRequest, $wgSitename, $wgUser;

		$lang = $this->helper->getLangForSearchResults();

		$centralUrl = $this->helper->getCentralUrlFromGlobalTitle( $lang );
		$globalSearchUrl = $this->helper->getGlobalSearchUrl( $centralUrl );
		$localSearchUrl = SpecialPage::getTitleFor( 'Search' )->getFullUrl();
		$fulltext = $wgUser->getOption( 'enableGoSearch' ) ? 0 : 'Search';
		$query = $wgRequest->getVal( 'search', $wgRequest->getVal( 'query', '' ) );
		$localSearchPlaceholder = html_entity_decode(
			wfMessage( 'global-navigation-local-search-placeholder', $wgSitename )->parse()
		);
		if ( WikiaPageType::isCorporatePage() && !WikiaPageType::isWikiaHub() ) {
			$this->response->setVal( 'disableLocalSearchOptions', true );
			$this->response->setVal( 'defaultSearchPlaceholder', wfMessage( 'global-navigation-global-search')->escaped() );
			$this->response->setVal( 'defaultSearchUrl', $globalSearchUrl );
		} else {
			$this->response->setVal( 'globalSearchUrl', $globalSearchUrl );
			$this->response->setVal( 'localSearchUrl', $localSearchUrl );
			$this->response->setVal( 'localSearchPlaceholder', $localSearchPlaceholder);
			$this->response->setVal( 'defaultSearchPlaceholder',  $localSearchPlaceholder);
			$this->response->setVal( 'defaultSearchUrl', $localSearchUrl );
		}

		$this->response->setVal( 'fulltext', $fulltext );
		$this->response->setVal( 'query', $query );
		$this->response->setVal( 'lang', $lang );
	}

	public function hubsMenu() {
		$menuNodes = $this->getMenuNodes();

		// use transparent background to fill the space
		// when we do not get enough hubs (CON-1820)
		while ( count( $menuNodes ) < self::HUBS_COUNT ) {
			$menuNodes[] = [
				'placeholder' => true,
			];
		}

		$this->response->setVal( 'menuNodes', $menuNodes );

		$activeNode = $this->getActiveNode();
		$activeNodeIndex = $this->getActiveNodeIndex( $menuNodes, $activeNode );
		$this->response->setVal( 'activeNodeIndex', $activeNodeIndex );
	}

	public function hubsMenuSections() {
		$menuSections = $this->request->getVal( 'menuSections', [] );
		$this->response->setVal( 'menuSections', $menuSections );
	}

	public function lazyLoadHubsMenu() {
		$lazyLoadMenuNodes = $this->getMenuNodes();

		$activeNode = $this->getActiveNode();
		$activeNodeIndex = $this->getActiveNodeIndex( $lazyLoadMenuNodes, $activeNode );
		array_splice( $lazyLoadMenuNodes, $activeNodeIndex, 1 );

		$this->response->setVal( 'menuSections', $lazyLoadMenuNodes );
		$this->overrideTemplate( 'hubsMenuSections' );

		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	private function getMenuNodes() {
		$menuNodes = ( new NavigationModel( true /* useSharedMemcKey */ ) )->getGlobalNavigationTree(
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
		$verticalId = $wikiFactoryHub->getVerticalId( $wgCityId );

		$allVerticals = $wikiFactoryHub->getAllVerticals();
		if ( isset( $allVerticals[$verticalId]['short'] ) ) {
			$activeNode = $allVerticals[$verticalId]['short'];
		}

		return $activeNode;
	}


	protected function isGameStarLogoEnabled() {
		return $this->wg->contLang->getCode() == 'de';
	}
}
