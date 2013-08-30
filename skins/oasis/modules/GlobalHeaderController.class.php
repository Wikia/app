<?php

class GlobalHeaderController extends WikiaController {
	private $menuNodes;

	public function init() {
	}

	public function index() {
		wfProfileIn(__METHOD__);
		$this->response->addAsset('ui_repo_api_js');
		$this->response->addAsset('skins/oasis/js/GlobalHeader.js');

		$userLang = $this->wg->Lang->getCode();

		global $wgCityId;
		$this->response->setVal('category', HubService::getCategoryInfoForCurrentPage());

		// Link to Wikia home page
		$centralUrl = 'http://www.wikia.com/Wikia';
		if (!empty($this->wg->LangToCentralMap[$userLang])) {
			$centralUrl = $this->wg->LangToCentralMap[$userLang];
		}

		$this->response->setVal('centralUrl', $centralUrl);
		$isGameStarLogoEnabled = $this->isGameStarLogoEnabled();
		$this->response->setVal('isGameStarLogoEnabled', $isGameStarLogoEnabled);
		if($isGameStarLogoEnabled) {
			$this->response->addAsset('skins/oasis/css/modules/GameStarLogo.scss');
		}

		$this->response->setVal( 'displayHeader', !$this->wg->HideNavigationHeaders );

		wfProfileOut(__METHOD__);
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
