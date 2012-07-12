<?php

class GlobalHeaderController extends WikiaController {
	const CACHE_TTL = 10800; // 3 hours
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

		$navigation = new NavigationService(true/* useSharedMemcKey */);
		$menuNodes = $navigation->parseMessage($messageName, array(3, 4, 5), self::CACHE_TTL);

		wfRunHooks('AfterGlobalHeader', array(&$menuNodes, $category, $messageName));

		$this->menuNodes = $menuNodes;

		$this->app->wf->ProfileIn(__METHOD__);
	}

	public function index() {
		global $wgLangToCentralMap, $wgLang;

		$userLang = $wgLang->getCode();

		// Link to Wikia home page
		$centralUrl = 'http://www.wikia.com/Wikia';
		if (!empty($wgLangToCentralMap[$userLang])) {
			$centralUrl = $wgLangToCentralMap[$userLang];
		}

		$createWikiUrl = 'http://www.wikia.com/Special:CreateWiki';
		if ($userLang != 'en') {
			$createWikiUrl .= '?uselang=' . $userLang;
		}

		$this->response->setVal('centralUrl', $centralUrl);
		$this->response->setVal('createWikiUrl', $createWikiUrl);
		$this->response->setVal('menuNodes', $this->menuNodes);
		$this->response->setVal('topNavMenuItems', $this->menuNodes[0]['children']);
	}

	public function menuItems() {
		$index = $this->request->getVal('index', 0);
		$this->response->setVal('menuNodes', $this->menuNodes);
		$this->response->setVal('subNavMenuItems', $this->menuNodes[$index]['children']);

		// FIXME: should be cached until menuNodes are regenerated
		//$this->response->setCacheValidity(self::CACHE_TTL, self::CACHE_TTL, array(
		//	WikiaResponse::CACHE_TARGET_BROWSER,
		//	WikiaResponse::CACHE_TARGET_VARNISH
		//));
	}
}