<?php

class GlobalHeaderController extends WikiaController {
	private $menuNodes;

	public function init() {
		global $wgCityId;

		$this->app->wf->ProfileIn(__METHOD__);

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
			10800 /* 3 hours */
		);

		wfRunHooks('AfterGlobalHeader', array(&$menuNodes, $category, $messageName));

		$this->menuNodes = $menuNodes;

		$this->app->wf->ProfileOut(__METHOD__);
	}

	public function index() {
		global $wgLangToCentralMap, $wgLang;

		$userLang = $wgLang->getCode();

		// Link to Wikia home page
		$centralUrl = 'http://www.wikia.com/Wikia';
		if (!empty($wgLangToCentralMap[$userLang])) {
			$centralUrl = $wgLangToCentralMap[$userLang];
		}

		$createWikiUrl = 'http://www.wikia.com/Special:CreateNewWiki';
		if ($userLang != 'en') {
			$createWikiUrl .= '?uselang=' . $userLang;
		}

		$this->response->setVal('centralUrl', $centralUrl);
		$this->response->setVal('createWikiUrl', $createWikiUrl);
		$this->response->setVal('menuNodes', $this->menuNodes);
		$this->response->setVal('menuNodesHash', $this->menuNodes[0]['hash']);
		$this->response->setVal('topNavMenuItems', $this->menuNodes[0]['children']);
		$isGameStarLogoEnabled = $this->isGameStarLogoEnabled();
		$this->response->setVal('isGameStarLogoEnabled', $isGameStarLogoEnabled);
		if($isGameStarLogoEnabled) {
			$this->response->addAsset('skins/oasis/css/modules/GameStarLogo.scss');
		}

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
		$this->response->setCacheValidity(86400, 86400, array(
			WikiaResponse::CACHE_TARGET_BROWSER,
			WikiaResponse::CACHE_TARGET_VARNISH
		));
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