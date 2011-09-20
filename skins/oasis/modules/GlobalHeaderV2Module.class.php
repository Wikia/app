<?php

class GlobalHeaderV2Module extends Module {

	var $wgBlankImgUrl;
	var $wgStylePath;
	var $wgCdnStylePath;
	var $wgEnableSpotlightsV2_GlobalNav;
	var $wgABTests;

	var $centralUrl;
	var $createWikiUrl;
	var $createWikiText;
	var $menuNodes;

	public function executeIndex() {
		global $wgLangToCentralMap, $wgContLang, $wgCityId, $wgLang;
		
		$wikiLang = $wgLang->getCode();
		
		// generate link to hompage; bugId:7452
		$this->centralUrl = 'http://www.wikia.com/Wikia';

		// generate link to AutoWikiCreate
		$userlang = ($wikiLang == 'en') ? '' : "?uselang=$wikiLang";
		$this->createWikiUrl = "http://www.wikia.com/Special:CreateWiki{$userlang}";
		$this->createWikiText = wfMsgHtml('oasis-global-nav-create-wiki');


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
