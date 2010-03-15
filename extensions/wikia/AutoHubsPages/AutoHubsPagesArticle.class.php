<?php

/*
 * Author: Bartek Lapinski
 *
 */

// this basically overwrites the article view for tag pages

class AutoHubsPagesArticle extends Article {


	public function prepareData() {
		global $wgTitle, $wgUser;
		print_r( json_decode(file_get_contents('fakedata.json'),true ));
			exit;
			
		$pars = array();
		$pars['slider'] = array();
		if (class_exists("WikiaStatsAutoHubsConsumerDB")){
			
			$data = AutoHubsPagesData::newFromTagTitle($wgTitle);
			$tagname = AutoHubsPagesHelper::getHubNameFromTitle($wgTitle);	
			$vars = AutoHubsPagesHelper::getHubsFeedsVariable( $tagname );
		
			$lang = "en";
			$isMenager = $wgUser->isAllowed( 'corporatepagemanager' );
			$datafeeds = new WikiaStatsAutoHubsConsumerDB(DB_SLAVE);
			$tag_id = AutoHubsPagesHelper::getHubIdFromTitle($wgTitle);
			$tag_name = AutoHubsPagesHelper::getHubNameFromTitle($wgTitle);

			$pars['tagname'] = $tag_name;
			$pars['title'] = $wgTitle;
			$pars['var_feeds'] = $vars[$tag_name];
			$pars['is_menager'] = $isMenager;
			$pars['tag_id'] = $isMenager;
			if ($isMenager) {
				$temp = $datafeeds->getTopWikis($tag_id, $lang, 30, true, true);
				
				$pars['topWikis1'] = array_slice($temp['value'],0,15);
				$pars['topWikis2'] = array_slice($temp['value'],15,15);					
			} else {
				$temp = $datafeeds->getTopWikis($tag_id, $lang, 20, false);

				$pars['topWikis1'] = array_slice($temp['value'],0,10);
				$pars['topWikis2'] = array_slice($temp['value'],10,10);
			}
			
			$pars['topWikisOne'] = $temp['value'][$temp['number_one']];

			$temp = $datafeeds->getTopUsers($tag_id,'en',5);
			$pars['topEditors'] = $temp['value'];

			if ($isMenager) {
				$temp = $datafeeds->getTopBlogs($tag_id, $lang, 9, 3, true, true);
			} else {
				$temp = $datafeeds->getTopBlogs($tag_id, "en", 3, 1);
			}
			
			$pars['topBlogs'] = $temp['value'];
		
			if ($isMenager) {
				$temp = $datafeeds->getTopArticles($tag_id, $lang, 15, 3, true, true);
			} else {
				$temp = $datafeeds->getTopArticles($tag_id, "en", 5, 1);
			}
			
			$pars['hotSpots'] = $temp['value'];
			$pars['slider'] = CorporatePageHelper::parseMsgImg('Hub-' . $tag_name . '-slider',true);

			$pars['wikia_whats_up'] = wfMsgExt("corporatepage-wikia-whats-up",array("parsemag"));
		} else {

			$wikis = json_decode('{"value":{"490":{"0":"490","city_id":"490","1":"worldofwarcraft","city_sitename":"worldofwarcraft","2":"http:\/\/www.wowwiki.com\/","city_url":"http:\/\/www.wowwiki.com\/","3":"WoWWiki","city_title":"WoWWiki","count":"2528402"},"410":{"0":"410","city_id":"410","1":"yugioh","city_sitename":"yugioh","2":"http:\/\/yugioh.wikia.com\/","city_url":"http:\/\/yugioh.wikia.com\/","3":"Yu-Gi-Oh!","city_title":"Yu-Gi-Oh!","count":"1465949"},"11432":{"0":"11432","city_id":"11432","1":"wikicities","city_sitename":"wikicities","2":"http:\/\/lostpedia.wikia.com\/","city_url":"http:\/\/lostpedia.wikia.com\/","3":"Lostpedia","city_title":"Lostpedia","count":"974724"},"304":{"0":"304","city_id":"304","1":"runescape","city_sitename":"runescape","2":"http:\/\/runescape.wikia.com\/","city_url":"http:\/\/runescape.wikia.com\/","3":"RuneScape Wiki","city_title":"RuneScape Wiki","count":"837311"},"147":{"0":"147","city_id":"147","1":"starwars","city_sitename":"starwars","2":"http:\/\/starwars.wikia.com\/","city_url":"http:\/\/starwars.wikia.com\/","3":"Wookieepedia","city_title":"Wookieepedia","count":"822707"},"3491":{"0":"3491","city_id":"3491","1":"wikicities","city_sitename":"wikicities","2":"http:\/\/masseffect.wikia.com\/","city_url":"http:\/\/masseffect.wikia.com\/","3":"Mass Effect Wiki","city_title":"Mass Effect Wiki","count":"807759"},"3035":{"0":"3035","city_id":"3035","1":"wikicities","city_sitename":"wikicities","2":"http:\/\/fallout.wikia.com\/","city_url":"http:\/\/fallout.wikia.com\/","3":"The Vault","city_title":"The Vault","count":"759292"},"1657":{"0":"1657","city_id":"1657","1":"ffxi","city_sitename":"ffxi","2":"http:\/\/wiki.ffxiclopedia.org\/","city_url":"http:\/\/wiki.ffxiclopedia.org\/","3":"FFXIclopedia","city_title":"FFXIclopedia","count":"710411"},"10150":{"0":"10150","city_id":"10150","1":"wikicities","city_sitename":"wikicities","2":"http:\/\/dragonage.wikia.com\/","city_url":"http:\/\/dragonage.wikia.com\/","3":"Dragon Age Wiki","city_title":"Dragon Age Wiki","count":"649561"},"3125":{"0":"3125","city_id":"3125","1":"wikicities","city_sitename":"wikicities","2":"http:\/\/callofduty.wikia.com\/","city_url":"http:\/\/callofduty.wikia.com\/","3":"Call of Duty Wiki","city_title":"Call of Duty Wiki","count":"612252"},"1318":{"0":"1318","city_id":"1318","1":"naruto","city_sitename":"naruto","2":"http:\/\/naruto.wikia.com\/","city_url":"http:\/\/naruto.wikia.com\/","3":"Narutopedia","city_title":"Narutopedia","count":"444633"},"351":{"0":"351","city_id":"351","1":"en.tibia","city_sitename":"en.tibia","2":"http:\/\/tibia.wikia.com\/","city_url":"http:\/\/tibia.wikia.com\/","3":"TibiaWiki","city_title":"TibiaWiki","count":"429948"},"324":{"0":"324","city_id":"324","1":"eq2","city_sitename":"eq2","2":"http:\/\/eq2.wikia.com\/","city_url":"http:\/\/eq2.wikia.com\/","3":"EverQuest 2 Wiki","city_title":"EverQuest 2 Wiki","count":"369434"},"11954":{"0":"11954","city_id":"11954","1":"wikicities","city_sitename":"wikicities","2":"http:\/\/borderlands.wikia.com\/","city_url":"http:\/\/borderlands.wikia.com\/","3":"Borderlands Wiki","city_title":"Borderlands Wiki","count":"314069"},"174":{"0":"174","city_id":"174","1":"finalfantasy","city_sitename":"finalfantasy","2":"http:\/\/finalfantasy.wikia.com\/","city_url":"http:\/\/finalfantasy.wikia.com\/","3":"Final Fantasy Wiki","city_title":"Final Fantasy Wiki","count":"307334"},"3490":{"0":"3490","city_id":"3490","1":"wikicities","city_sitename":"wikicities","2":"http:\/\/bioshock.wikia.com\/","city_url":"http:\/\/bioshock.wikia.com\/","3":"BioShock Wiki","city_title":"BioShock Wiki","count":"287258"},"462":{"0":"462","city_id":"462","1":"halo","city_sitename":"halo","2":"http:\/\/halo.wikia.com\/","city_url":"http:\/\/halo.wikia.com\/","3":"Halopedia","city_title":"Halopedia","count":"285498"},"1081":{"0":"1081","city_id":"1081","1":"onepiece","city_sitename":"onepiece","2":"http:\/\/onepiece.wikia.com\/","city_url":"http:\/\/onepiece.wikia.com\/","3":"One Piece Encyclopedia","city_title":"One Piece Encyclopedia","count":"198450"},"26":{"0":"26","city_id":"26","1":"wesleyan","city_sitename":"wesleyan","2":"http:\/\/guildwars.wikia.com\/","city_url":"http:\/\/guildwars.wikia.com\/","3":"GuildWiki","city_title":"GuildWiki","count":"193442"},"3747":{"0":"3747","city_id":"3747","1":"wikicities","city_sitename":"wikicities","2":"http:\/\/bleach.wikia.com\/","city_url":"http:\/\/bleach.wikia.com\/","3":"Bleach Wiki","city_title":"Bleach Wiki","count":"193221"}},"age":1267014401}',true);
			$pars['topWikis1'] = array_slice($wikis['value'],0,10);
			$pars['topWikis2'] = array_slice($wikis['value'],10,10);
			$users = json_decode('{"value":[{"0":"1904444","user_id":"1904444","1":"12","tag_id":"12","2":"2010-02-24","date":"2010-02-24","3":"D\u00d8G","username":"D\u00d8G","4":"rollback;sysop","groups":"rollback;sysop","5":"42","all_count":"42"},{"0":"1429792","user_id":"1429792","1":"12","tag_id":"12","2":"2010-02-24","date":"2010-02-24","3":"Yyp","username":"Yyp","4":"rollback;sysop","groups":"rollback;sysop","5":"31","all_count":"31"},{"0":"61371","user_id":"61371","1":"12","tag_id":"12","2":"2010-02-24","date":"2010-02-24","3":"GrnMarvl14","username":"GrnMarvl14","4":"sysop","groups":"sysop","5":"29","all_count":"29"},{"0":"6652","user_id":"6652","1":"12","tag_id":"12","2":"2010-02-24","date":"2010-02-24","3":"Davidscarter","username":"Davidscarter","4":"bureaucrat;sysop","groups":"bureaucrat;sysop","5":"26","all_count":"26"},{"0":"22460","user_id":"22460","1":"12","tag_id":"12","2":"2010-02-24","date":"2010-02-24","3":"Sulfur","username":"Sulfur","4":"bureaucrat;sysop","groups":"bureaucrat;sysop","5":"22","all_count":"22"}],"age":1267097296}',true);
			$pars['topEditors'] = $users['value'];
			$hotSpots = json_decode('{"value":[{"0":"11432","city_id":"11432","1":"112648","page_id":"112648","2":"12","tag_id":"12","3":"2010-02-24","date":"2010-02-24","4":"Lighthouse_(episode)\/Theories","page_name":"Lighthouse (episode)\/Theories","5":"http:\/\/lostpedia.wikia.com\/wiki\/Lighthouse_(episode)\/Theories","page_url":"http:\/\/lostpedia.wikia.com\/wiki\/Lighthouse_(episode)\/Theories","6":"Lostpedia","wikiname":"Lostpedia","7":"http:\/\/lostpedia.wikia.com","wikiurl":"http:\/\/lostpedia.wikia.com","8":"32","all_count":"32","wiki_counter":1,"level":1,"real_pagename":"Lighthouse_(episode)\/Theories"},{"0":"1544","city_id":"1544","1":"5422","page_id":"5422","2":"12","tag_id":"12","3":"2010-02-24","date":"2010-02-24","4":"User_Battles_2","page_name":"User Battles 2","5":"http:\/\/villains.wikia.com\/wiki\/User_Battles_2","page_url":"http:\/\/villains.wikia.com\/wiki\/User_Battles_2","6":"Villains Wiki","wikiname":"Villains Wiki","7":"http:\/\/villains.wikia.com","wikiurl":"http:\/\/villains.wikia.com","8":"7","all_count":"7","wiki_counter":1,"level":2,"real_pagename":"User_Battles_2"},{"0":"11954","city_id":"11954","1":"18180","page_id":"18180","2":"12","tag_id":"12","3":"2010-02-24","date":"2010-02-24","4":"New_Gearbox_Weapons_in_DLC3","page_name":"New Gearbox Weapons in DLC3","5":"http:\/\/borderlands.wikia.com\/wiki\/Forum:New_Gearbox_Weapons_in_DLC3","page_url":"http:\/\/borderlands.wikia.com\/wiki\/Forum:New_Gearbox_Weapons_in_DLC3","6":"Borderlands Wiki","wikiname":"Borderlands Wiki","7":"http:\/\/borderlands.wikia.com","wikiurl":"http:\/\/borderlands.wikia.com","8":"5","all_count":"5","wiki_counter":1,"level":3,"real_pagename":"New_Gearbox_Weapons_in_DLC3"},{"0":"3747","city_id":"3747","1":"2418","page_id":"2418","2":"12","tag_id":"12","3":"2010-02-24","date":"2010-02-24","4":"Wonderweiss_Margera","page_name":"Wonderweiss Margera","5":"http:\/\/bleach.wikia.com\/wiki\/Wonderweiss_Margera","page_url":"http:\/\/bleach.wikia.com\/wiki\/Wonderweiss_Margera","6":"Bleach Wiki","wikiname":"Bleach Wiki","7":"http:\/\/bleach.wikia.com","wikiurl":"http:\/\/bleach.wikia.com","8":"5","all_count":"5","wiki_counter":1,"level":3,"real_pagename":"Wonderweiss_Margera"},{"0":"410","city_id":"410","1":"208213","page_id":"208213","2":"12","tag_id":"12","3":"2010-02-24","date":"2010-02-24","4":"How_about_a_new_gladiator_beast_support_card?","page_name":"How about a new gladiator beast support card?","5":"http:\/\/yugioh.wikia.com\/wiki\/Forum:How_about_a_new_gladiator_beast_support_card%3F","page_url":"http:\/\/yugioh.wikia.com\/wiki\/Forum:How_about_a_new_gladiator_beast_support_card%3F","6":"Yu-Gi-Oh!","wikiname":"Yu-Gi-Oh!","7":"http:\/\/yugioh.wikia.com","wikiurl":"http:\/\/yugioh.wikia.com","8":"5","all_count":"5","wiki_counter":1,"level":3,"real_pagename":"How_about_a_new_gladiator_beast_support_card?"}],"age":1267109250}',true);
			$pars['hotSpots'] = $hotSpots['value'];
			$topBlogs = json_decode('{"value":[{"0":"3035","city_id":"3035","1":"59252","page_id":"59252","2":"12","tag_id":"12","3":"2010-02-24","date":"2010-02-24","4":"Ausir\/German_PC_Games_Fallout:_New_Vegas_preview","page_name":"Ausir\/German_PC_Games_Fallout:_New_Vegas_preview","5":"http:\/\/fallout.wikia.com\/wiki\/User_blog:Ausir\/German_PC_Games_Fallout:_New_Vegas_preview","page_url":"http:\/\/fallout.wikia.com\/wiki\/User_blog:Ausir\/German_PC_Games_Fallout:_New_Vegas_preview","6":"The Vault","wikiname":"The Vault","7":"http:\/\/fallout.wikia.com","wikiurl":"http:\/\/fallout.wikia.com","8":"45","all_count":"45","wiki_counter":1},{"0":"6092","city_id":"6092","1":"10340","page_id":"10340","2":"12","tag_id":"12","3":"2010-02-25","date":"2010-02-25","4":"Abce2\/New_Bakugan_pics.","page_name":"Abce2\/New_Bakugan_pics.","5":"http:\/\/bakugan.wikia.com\/wiki\/User_blog:Abce2\/New_Bakugan_pics.","page_url":"http:\/\/bakugan.wikia.com\/wiki\/User_blog:Abce2\/New_Bakugan_pics.","6":"Bakugan Wiki","wikiname":"Bakugan Wiki","7":"http:\/\/bakugan.wikia.com","wikiurl":"http:\/\/bakugan.wikia.com","8":"9","all_count":"9","wiki_counter":1},{"0":"11432","city_id":"11432","1":"119063","page_id":"119063","2":"12","tag_id":"12","3":"2010-02-25","date":"2010-02-25","4":"Ztcrazy\/Kind_of_a_big_plot_hole?","page_name":"Ztcrazy\/Kind_of_a_big_plot_hole?","5":"http:\/\/lostpedia.wikia.com\/wiki\/User_blog:Ztcrazy\/Kind_of_a_big_plot_hole%3F","page_url":"http:\/\/lostpedia.wikia.com\/wiki\/User_blog:Ztcrazy\/Kind_of_a_big_plot_hole%3F","6":"Lostpedia","wikiname":"Lostpedia","7":"http:\/\/lostpedia.wikia.com","wikiurl":"http:\/\/lostpedia.wikia.com","8":"9","all_count":"9","wiki_counter":1}],"age":1267114727}',true);
			$pars['topBlogs'] = $topBlogs['value'];
		}
		return $pars;
	}

	// overwrite view, display tag page
	public function view() {
		global $wgOut;
		wfLoadExtensionMessages('AutoHubsPages');
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );	
		$oTmpl->set_vars(array(
			"data" => $this->prepareData()
		));
		$wgOut->addHTML( $oTmpl->render("article") );		
	}

	/**
	 * static entry point for hook
	 *
	 * @static
	 * @access public
	 */
	static public function ArticleFromTitle( &$title, &$article ) {
		if( !AutoHubsPagesHelper::isHubsPage( $title ) ) {
			return true;			
		}

		$article = new AutoHubsPagesArticle( $title );	

		return true;
	}

}






