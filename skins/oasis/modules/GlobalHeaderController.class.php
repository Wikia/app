<?php

class GlobalHeaderController extends WikiaController {
	private $menuNodes;
	const MAX_COUNT_OF_LEVEL1_NODES = 3;
	const MAX_COUNT_OF_LEVEL2_NODES = 4;
	const MAX_COUNT_OF_LEVEL3_NODES = 5;
	private $menuNodesAB;
	const MAX_COUNT_OF_LEVEL1_NODES_AB = 7;

	private static $categoryMapForAB = [
		WikiFactoryHub::CATEGORY_ID_GAMING => 'games',
		WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT => 'tv',
		WikiFactoryHub::CATEGORY_ID_LIFESTYLE => 'lifestyle',
		WikiFactoryHub::CATEGORY_ID_CORPORATE => null,
		WikiFactoryHub::CATEGORY_ID_MUSIC => 'music'
	];

	public function init() {
		wfProfileIn( __METHOD__ );

		$this->menuNodes = $this->prepareMenuData( 'shared-Globalnavigation', self::MAX_COUNT_OF_LEVEL1_NODES );

		wfProfileOut( __METHOD__ );
	}

	private function prepareMenuData( $messageName, $hubsCount ) {
		global $wgCityId;

		wfProfileIn( __METHOD__ );

		$category = WikiFactory::getCategory( $wgCityId );

		if ( $category ) {
			$messageNameWithCategory = $messageName . '-' . $category->cat_id;
			if ( !wfEmptyMsg( $messageNameWithCategory, wfMsg( $messageNameWithCategory ) ) ) {
				$messageName = $messageNameWithCategory;
			}
		}

		$navigation = new NavigationModel( true /* useSharedMemcKey */ );
		$menuNodes = $navigation->parse(
			NavigationModel::TYPE_MESSAGE,
			$messageName,
			[ $hubsCount, self::MAX_COUNT_OF_LEVEL2_NODES, self::MAX_COUNT_OF_LEVEL3_NODES ],
			1800 /* 3 hours */
		);

		wfRunHooks( 'AfterGlobalHeader', [ &$menuNodes, $category, $messageName ] );

		wfProfileOut( __METHOD__ );

		return $menuNodes;
	}

	public function index() {
		Wikia::addAssetsToOutput( 'global_header_css' );

		$userLang = $this->wg->Lang->getCode();

		// Link to Wikia home page
		$centralUrl = 'http://www.wikia.com/Wikia';
		if ( !empty( $this->wg->LangToCentralMap[ $userLang ] ) ) {
			$centralUrl = $this->wg->LangToCentralMap[ $userLang ];
		}

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
		$this->response->setVal( 'menuNodes', $this->menuNodes );
		$this->response->setVal( 'menuNodesHash', !empty( $this->menuNodes[ 0 ] ) ? $this->menuNodes[ 0 ][ 'hash' ] : null );
		$this->response->setVal( 'topNavMenuItems', !empty( $this->menuNodes[ 0 ] ) ? $this->menuNodes[ 0 ][ 'children' ] : null );
		$isGameStarLogoEnabled = $this->isGameStarLogoEnabled();
		$this->response->setVal( 'isGameStarLogoEnabled', $isGameStarLogoEnabled );
		if ( $isGameStarLogoEnabled ) {
			$this->response->addAsset( 'skins/oasis/css/modules/GameStarLogo.scss' );
		}
		$this->response->setVal( 'altMessage', $this->wg->CityId % 5 == 1 ? '-alt' : '' );
		$this->response->setVal( 'displayHeader', !$this->wg->HideNavigationHeaders );
	}

	public function menuItems() {
		$index = $this->request->getVal( 'index', 0 );
		$this->response->setVal( 'menuNodes', $this->menuNodes );
		$this->response->setVal( 'subNavMenuItems', $this->menuNodes[ $index ][ 'children' ] );
	}

	public function menuItemsAll() {
		$this->response->setFormat( 'json' );

		$indexes = $this->request->getVal( 'indexes', array() );

		$menuItems = array();
		foreach ( $indexes as $index ) {
			$menuItems[ $index ] = $this->app->renderView( 'GlobalHeader', 'menuItems', array( 'index' => $index ) );
		}

		$this->response->setData( $menuItems );

		// Cache for 1 day
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
	}

	protected function isGameStarLogoEnabled() {
		if ( $this->wg->contLang->getCode() == 'de' ) {
			$result = true;
		} else {
			$result = false;
		}
		return $result;
	}
}
