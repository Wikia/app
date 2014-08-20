<?php

class GlobalNavigationController extends WikiaController {

	public function index() {
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

	public function searchVenus() {
		$userLang = $this->wg->Lang->getCode();
		$centralUrl = 'http://www.wikia.com';
		if (!empty($this->wg->LangToCentralMap[$userLang])) {
			$centralUrl = $this->wg->LangToCentralMap[$userLang];
		}
		$specialSearchTitle = SpecialPage::getTitleFor('Search');

		$this->response->setVal('globalSearchUrl', $centralUrl . $specialSearchTitle->getLocalURL());
		$this->response->setVal('localSearchUrl', $specialSearchTitle->getFullUrl());
		$this->response->setVal('defaultSearchMessage', wfMessage('global-navigation-local-search')->text());
		$this->response->setVal('defaultSearchUrl', $specialSearchTitle->getFullUrl());
	}
}
