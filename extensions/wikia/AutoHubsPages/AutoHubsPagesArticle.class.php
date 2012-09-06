<?php

/*
 * Author: Bartek Lapinski
 *
 */

// this basically overwrites the article view for tag pages

class AutoHubsPagesArticle extends Article {


	public function prepareData() {
		global $wgTitle, $wgUser, $wgCont;

		$pars = array();
		$pars['slider'] = array();

		$lang = AutoHubsPagesHelper::getLangForHub($wgTitle);

		$data = AutoHubsPagesData::newFromTagTitle($wgTitle);
		$tagname = AutoHubsPagesHelper::getHubNameFromTitle($wgTitle);
		$vars = AutoHubsPagesHelper::getHubsFeedsVariable( $tagname );

		$isManager = $wgUser->isAllowed( 'corporatepagemanager' );
		$datafeeds = new WikiaStatsAutoHubsConsumerDB(DB_SLAVE);

		$tag_id = AutoHubsPagesHelper::getHubIdFromTitle($wgTitle);

		$tag_name = AutoHubsPagesHelper::getHubNameFromTitle($wgTitle);

		$pars['tagname'] = $tag_name;
		$pars['title'] = $wgTitle;
		$pars['var_feeds'] = $vars[$tag_name];
		$pars['is_manager'] = $isManager;
		$pars['tag_id'] = $tag_id;

		if ($isManager) {
			$temp = $datafeeds->getTopWikis($tag_id, $lang, 30, true, true);
			$pars['topWikis1'] = $temp['value'];
		} else {
			$temp = $datafeeds->getTopWikis($tag_id, $lang, 10, false);
			$pars['topWikis1'] = $temp['value'];
		}

		$temp = $datafeeds->getTopUsers($tag_id, $lang,5);
		$pars['topEditors'] = $temp['value'];

		if ($isManager) {
			$temp = $datafeeds->getTopBlogs($tag_id, $lang, 9, 3, true, true);
		} else {
			$temp = $datafeeds->getTopBlogs($tag_id, $lang, 3, 1);
		}

		$pars['topBlogs'] = $temp['value'];

		if ($isManager) {
			$temp = $datafeeds->getTopArticles($tag_id, $lang, 15, 3, true, true, true);
		} else {
			$temp = $datafeeds->getTopArticles($tag_id, $lang, 5, 1, false, false, true);
		}

		$pars['hotSpots'] = $temp['value'];
		$pars['slider'] = CorporatePageHelper::parseMsgImg( 'hub-' . $tag_name . '-slider', true );

		$pars['wikia_whats_up'] = wfMsgExt("corporatepage-wikia-whats-up",array("parsemag"));

		return $pars;
	}

	// overwrite view, display tag page
	public function view() {
		global $wgOut, $wgTitle;

		$data = $this->prepareData();
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars(array(
			"data" => $data
		));

		$wgOut->setHTMLTitle( wfMsg('hub-header', $data['title']) ); // does not add a h1, this is done later

		if ( F::app()->checkSkin( 'oasis' ) ) {
			$hubName = $wgTitle->getText();

			$wgOut->addHTML(F::app()->renderView('BlogsInHubs', 'HotNews', array('hubName' => $hubName)));
			$wgOut->addHTML(F::app()->renderView('CorporateSite', 'TopHubWikis'));
			parent::view();
		} else {
			$wgOut->addHTML( $oTmpl->render("article") );
		}
	}

	// Always return true even if we don't have article content otherwise Mediawiki throws a 404
	// BugId: 8937 8942
	public function hasViewableContent () {
		return true;
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






