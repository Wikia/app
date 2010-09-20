<?php

class GlobalHeaderModule extends Module {

	var $wgBlankImgUrl;
	var $wgStylePath;
	var $wgCdnStylePath;

	var $centralUrl;
	var $createWikiUrl;
	var $menuNodes;
	
	var $wgSingleH1;
	
	public function executeIndex() {
		global $wgLangToCentralMap, $wgContLang, $wgCityId, $wgUser, $wgLang, $wgCdnStylePath, $wgMemc, $wgSingleH1;
		
		$this->wgCdnStylePath = $wgCdnStylePath;

		// generate link to central wiki for language of this wiki
		$this->centralUrl = Wikia::langToSomethingMap($wgLangToCentralMap, $wgContLang->getCode(), 'http://www.wikia.com/Wikia');

		// generate link to AutoWikiCreate
		$userlang = $wgLang->getCode();
		$userlang = $userlang == 'en' ? '' : "?uselang=$userlang";

		$this->createWikiUrl = "http://www.wikia.com/Special:CreateWiki{$userlang}";

		$mKey = wfMemcKey('mOasisGlobalHeaderNodes');
		$this->menuNodes = $wgMemc->get($mKey);
		if (empty($this->menuNodes)) {
			// global menu
			$cat = WikiFactory::getCategory($wgCityId);
			if($cat === false || wfEmptyMsg('shared-Globalnavigation-'.$cat->cat_id, $text = wfMsg('shared-Globalnavigation-'.$cat->cat_id))) {
				$text = wfMsg('shared-Globalnavigation');
			}
			$service = new NavigationService();
			$this->menuNodes = $service->parseLines(explode("\n", $text), array(3, 4, 5));
			$wgMemc->set($mKey, $this->menuNodes, 86400);
			// TODO: is there an event we can hook for invalidation?
		}
	}
}
