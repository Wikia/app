<?php

class GlobalNavigationController extends WikiaController {

	public function venus() {
		Wikia::addAssetsToOutput('global_navigation_css');
		Wikia::addAssetsToOutput('global_navigation_js');
		// TODO remove after when Oasis is retired
		Wikia::addAssetsToOutput('global_navigation_oasis_css');

		$userLang = $this->wg->Lang->getCode();
		// Link to Wikia home page
		$centralUrl = 'http://www.wikia.com/Wikia';
		if (!empty($this->wg->LangToCentralMap[$userLang])) {
			$centralUrl = $this->wg->LangToCentralMap[$userLang];
		}

		$createWikiUrl = GlobalTitle::newFromText(
			'CreateNewWiki',
			NS_SPECIAL,
			WikiService::WIKIAGLOBAL_CITY_ID
		)->getFullURL();

		if ($userLang != 'en') {
			$createWikiUrl .= '?uselang=' . $userLang;
		}

		$this->response->setVal('centralUrl', $centralUrl);
		$this->response->setVal('createWikiUrl', $createWikiUrl);
	}

	public function hubsMenu() {
		$menuNodes = $this->getMenuNodes();
		$this->response->setVal('menuNodes', $menuNodes);

		$activeNode = $this->getActiveNode();
		$activeNodeIndex = $this->getActiveNodeIndex($menuNodes, $activeNode);
		$this->response->setVal('activeNodeIndex', $activeNodeIndex);
	}

	public function lazyLoadHubsMenu() {
		$langCode = $this->request->getVal('lang', null);

		$lazyLoadMenuNodes = $this->getMenuNodes( $langCode );

		$activeNode = $this->getActiveNode();
		$activeNodeIndex = $this->getActiveNodeIndex($lazyLoadMenuNodes, $activeNode);
		array_splice($lazyLoadMenuNodes, $activeNodeIndex, 1);

		$this->response->setFormat( 'json' );
		$this->response->setData($lazyLoadMenuNodes);
	}

	private function getMenuNodes( $langCode = null ) {
		$menuNodes = (new NavigationModel(true /* useSharedMemcKey */, $langCode) )->getTree(
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

		if ( $verticalId != WikiFactoryHub::HUB_ID_OTHER ) {
			$allVerticals = $wikiFactoryHub->getAllVerticals();
			if ( isset( $allVerticals[$verticalId]['short'] ) ) {
				$activeNode = $allVerticals[$verticalId]['short'];
			}
		} else {
			$categoryId = WikiFactory::getCategory( $wgCityId )->cat_id;

			switch( $categoryId ) {
				case WikiFactoryHub::CATEGORY_ID_GAMING:
					$activeNode = 'games';
					break;
				case WikiFactoryHub::CATEGORY_ID_MUSIC:
					$activeNode = 'music';
					break;
				case WikiFactoryHub::CATEGORY_ID_ENTERTAINMENT:
					$activeNode = 'tv';
					break;
				default:
					$activeNode = 'lifestyle';
			}
		}

		return $activeNode;
	}
}
