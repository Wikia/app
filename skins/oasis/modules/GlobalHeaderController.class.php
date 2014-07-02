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

	/*
	 * This (recursive) function generates tree from menuNodes.
	 * It basically reverts part of NavigationModel parse; changes simple array
	 * structure to a nested tree of elements; contain text, href
	 * and specialAttr for given menu node and all it's children nodes.
	 *
	 * NOTICE: This approach is (very) suboptimal, but it suits A/B test needs.
	 * In future (production) approach we'll probably want to refactor NavigationModel
	 * itself and work on that, but the amount of work needed for that is too large
	 * for simple A/B test.
	 *
	 * Source ticket: CON-804
	 *
	 * IMPORTANT: This function will be called 60 times as on 2014-04-04 - three hubs,
	 * four submenus for each hub, five links in each submenu.
	 *
	 * Number of calls changed to 140 (7 hubs, not 3) as on 2014-06-27.
	 *
	 * @param $index integer of menuitem index to generate data from
	 * @return array tree of menu nodes for given index
	 */
	private function recursiveConvertMenuNodeToArray( $index ) {
		$node = $this->menuNodesAB[ $index ];
		$returnValue = [
			'text' => $node[ 'text' ],
			'href' => $node[ 'href' ],
		];
		if ( !empty( $node[ 'specialAttr' ] ) ) {
			$returnValue[ 'specialAttr' ] = $node[ 'specialAttr' ];
		}

		if ( isset( $node[ 'children' ] ) ) {
			$children = [];

			foreach ( $node[ 'children' ] as $childId ) {
				$children[] = $this->recursiveConvertMenuNodeToArray( $childId );
			}

			$returnValue[ 'children' ] = $children;
		}

		return $returnValue;
	}

	public function getGlobalMenuItems() {
		global $wgCityId;

		$this->menuNodesAB = $this->prepareMenuData( 'shared-global-navigation-abtest', self::MAX_COUNT_OF_LEVEL1_NODES_AB );

		$menuData = [];

		// convert menuNodes to better json menu
		foreach ( $this->menuNodesAB[ 0 ][ 'children' ] as $id ) {
			$menuData[] = $this->recursiveConvertMenuNodeToArray( $id );
		}

		$catArr = WikiFactory::getCategory( $wgCityId );
		$catId = $catArr->cat_id;

		$menuData = [
			'active' => self::$categoryMapForAB[ $catId ],
			'menu' => $menuData
		];

		// respond
		$this->response->setFormat( 'json' );
		$this->response->setData( $menuData );
		// Cache for 1 day
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
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
