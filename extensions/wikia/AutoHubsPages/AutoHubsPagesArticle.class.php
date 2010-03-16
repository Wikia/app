<?php

/*
 * Author: Bartek Lapinski
 *
 */

// this basically overwrites the article view for tag pages

class AutoHubsPagesArticle extends Article {


	public function prepareData() {
		global $wgTitle, $wgUser;

		$pars = array();
		$pars['slider'] = array();
		if ( class_exists("WikiaStatsAutoHubsConsumerDB") ){
			
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
			$dir = dirname(__FILE__) . '/';
			$pars =  json_decode(file_get_contents($dir.'fakedata.json'),true );
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






