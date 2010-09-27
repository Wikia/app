<?php

class GlobalHeaderModule extends Module {

	var $wgBlankImgUrl;
	var $wgStylePath;
	var $wgCdnStylePath;
	var $wgSingleH1;

	var $centralUrl;
	var $createWikiUrl;
	var $menuNodes;

	public function executeIndex() {
		global $wgLangToCentralMap, $wgContLang, $wgCityId, $wgLang;

		// generate link to central wiki for language of this wiki
		$this->centralUrl = Wikia::langToSomethingMap($wgLangToCentralMap, $wgContLang->getCode(), 'http://www.wikia.com/Wikia');

		// generate link to AutoWikiCreate
		$userlang = $wgLang->getCode();
		$userlang = $userlang == 'en' ? '' : "?uselang=$userlang";

		$this->createWikiUrl = "http://www.wikia.com/Special:CreateWiki{$userlang}";

		// global navigation menu
		$category = WikiFactory::getCategory($wgCityId);

		if($category && !wfEmptyMsg('shared-Globalnavigation-'.$category->cat_id, $text = wfMsg('shared-Globalnavigation-'.$category->cat_id))) {
			$messageName = 'shared-Globalnavigation-'.$category->cat_id;
		} else {
			$messageName = 'shared-Globalnavigation';
		}

		$service = new NavigationService();
		$this->menuNodes = $service->parseMessage($messageName, array(3, 4, 5), 60*60*3 /* 3 hours */);
	}
}
