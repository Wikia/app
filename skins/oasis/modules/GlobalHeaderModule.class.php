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

		$messageName = 'shared-Globalnavigation-'.$category->cat_id;

		if($category === false || wfEmptyMsg($messageName, $text = wfMsg($messageName))) {
			$messageName = 'shared-Globalnavigation';
		}

		$service = new NavigationService();
		$this->menuNodes = $service->parseMessage($messageName, array(3, 4, 5), 60*60*3 /* 3 hours */);



/*


		$mKey = wfMemcKey('mOasisGlobalHeaderNodes', $userlang);
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
*/

	}
}
