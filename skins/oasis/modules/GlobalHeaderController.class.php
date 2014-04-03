<?php

class GlobalHeaderController extends WikiaController {
	private $menuNodes;

	public function init() {
		global $wgCityId;

		wfProfileIn(__METHOD__);

		$category = WikiFactory::getCategory($wgCityId);

		$messageName = 'shared-Globalnavigation';
		if ($category) {
			$messageNameWithCategory = $messageName . '-' . $category->cat_id;
			if (!wfEmptyMsg($messageNameWithCategory, wfMsg($messageNameWithCategory))) {
				$messageName = $messageNameWithCategory;
			}
		}

		$navigation = new NavigationModel(true /* useSharedMemcKey */);
		$menuNodes = $navigation->parse(
			NavigationModel::TYPE_MESSAGE,
			$messageName,
			array(3, 4, 5),
			1800 /* 3 hours */
		);

		wfRunHooks('AfterGlobalHeader', array(&$menuNodes, $category, $messageName));

		$this->menuNodes = $menuNodes;

		wfProfileOut(__METHOD__);
	}

	public function index() {
		global $wgOut;

		$userLang = $this->wg->Lang->getCode();

		// Link to Wikia home page
		$centralUrl = 'http://www.wikia.com/Wikia';
		if (!empty($this->wg->LangToCentralMap[$userLang])) {
			$centralUrl = $this->wg->LangToCentralMap[$userLang];
		}

		$createWikiUrl = GlobalTitle::newFromText(
			'CreateNewWiki',
			NS_SPECIAL,
			Wikia::MAIN_CORPORATE_WIKI_ID
		)->getFullURL();

		if ($userLang != 'en') {
			$createWikiUrl .= '?uselang=' . $userLang;
		}

		$this->response->setVal('centralUrl', $centralUrl);
		$this->response->setVal('createWikiUrl', $createWikiUrl);
		$this->response->setVal('menuNodes', $this->menuNodes);
		$this->response->setVal('menuNodesHash', !empty($this->menuNodes[0]) ? $this->menuNodes[0]['hash'] : null);
		$this->response->setVal('topNavMenuItems', !empty($this->menuNodes[0]) ? $this->menuNodes[0]['children'] : null);
		$isGameStarLogoEnabled = $this->isGameStarLogoEnabled();
		$this->response->setVal('isGameStarLogoEnabled', $isGameStarLogoEnabled);
		if($isGameStarLogoEnabled) {
			$this->response->addAsset('skins/oasis/css/modules/GameStarLogo.scss');
		}
		$this->response->setVal( 'altMessage', $this->wg->CityId % 5 == 1 ? '-alt' : '' );
		$this->response->setVal( 'displayHeader', !$this->wg->HideNavigationHeaders );
	}

	private function recursiveConvertMenuNodeToArray($index) {
		$node = $this->menuNodes[$index];
		$returnValue = [
			'text' => $node['text'],
			'href' => $node['href'],
		];
		if ( !empty( $node['specialAttr'] ) ) {
			$returnValue['specialAttr'] = $node['specialAttr'];
		}

		if ( isset( $node['children'] ) ) {
			$children = [];

			foreach ($node['children'] as $childId) {
				$children[] = $this->recursiveConvertMenuNodeToArray($childId);
			}

			$returnValue['children'] = $children;
		}

		return $returnValue;
	}

	public function getGlobalMenuItems() {
		// convert menuNodes to better json menu
		$nodes = $this->menuNodes;
		$menuData = [];

		foreach($nodes[0]['children'] as $id) {
			$menuData[] = $this->recursiveConvertMenuNodeToArray($id);
		}
		// respond
		$this->response->setFormat('json');
		$this->response->setData($menuData);
		// Cache for 1 day
		$this->response->setCacheValidity(WikiaResponse::CACHE_STANDARD);
	}

	public function menuItems() {
		$index = $this->request->getVal('index', 0);
		$this->response->setVal('menuNodes', $this->menuNodes);
		$this->response->setVal('subNavMenuItems', $this->menuNodes[$index]['children']);
	}

	public function menuItemsAll() {
		$this->response->setFormat('json');

		$indexes = $this->request->getVal('indexes', array());

		$menuItems = array();
		foreach($indexes as $index) {
			$menuItems[$index] = $this->app->renderView('GlobalHeader', 'menuItems', array('index' => $index));
		}

		$this->response->setData($menuItems);

		// Cache for 1 day
		$this->response->setCacheValidity(WikiaResponse::CACHE_STANDARD);
	}

	protected function isGameStarLogoEnabled() {
		if($this->wg->contLang->getCode() == 'de') {
			$result = true;
		} else {
			$result = false;
		}
		return $result;
	}
}
