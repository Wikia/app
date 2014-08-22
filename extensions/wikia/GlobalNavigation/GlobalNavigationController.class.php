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
			'shared-global-navigation-abtest'
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

	private function getActiveNode() {
		// TODO get proper category
		$activeNode = 'tv';

		return $activeNode;
	}
}
