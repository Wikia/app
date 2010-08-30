<?php

class GlobalHeaderModule extends Module {

	var $wgBlankImgUrl;
	var $wgStylePath;

	var $centralUrl;
	var $createWikiUrl;
	var $menuNodes;

	public function executeIndex() {
		global $wgLangToCentralMap, $wgContLang, $wgCityId, $wgUser, $wgLang;

		// generate link to central wiki for language of this wiki
		$this->centralUrl = Wikia::langToSomethingMap($wgLangToCentralMap, $wgContLang->getCode(), 'http://www.wikia.com/Wikia');

		// generate link to AutoWikiCreate
		$userlang = $wgLang->getCode();
		$userlang = $userlang == 'en' ? '' : "?uselang=$userlang";

		$this->createWikiUrl = "http://www.wikia.com/Special:CreateWiki{$userlang}";

		// global menu
		$cat = WikiFactory::getCategory($wgCityId);
		if($cat === false || wfEmptyMsg('shared-Globalnavigation-'.$cat->cat_id, $text = wfMsg('shared-Globalnavigation-'.$cat->cat_id))) {
			$text = wfMsg('shared-Globalnavigation');
		}
		$service = new NavigationService();
		$this->menuNodes = $service->parseLines(explode("\n", $text), array(3, 4, 5));
	}

}
