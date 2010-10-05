<?php
/**
 * Description of CorporateModule
 *
 * @author owen
 */
class CorporateSiteModule extends Module {
	// globals
	var $wgUser;

	var $slider;
	var $slider_class;
	var $data;

	var $is_menager;  // fix this typo

	// fix these
	var $hidehotspots;
	var $hidetopwikis;
	var $hidetopblogs;
	var $hidetopeditors;

// These are just templates
	public function executeCreateWiki() {

	}

	public function executeFollowUs() {

	}

	public function executeFacebookLike() {

	}


// FIXME: refactor the common functionality out of these
	public function executeTopHubWikis() {
		global $wgUser, $wgTitle;

		$isManager = $wgUser->isAllowed( 'corporatepagemanager' );
		$datafeeds = new WikiaStatsAutoHubsConsumerDB(DB_SLAVE);

		$lang = AutoHubsPagesHelper::getLangForHub($wgTitle);
		$tag_id = AutoHubsPagesHelper::getHubIdFromTitle($wgTitle);
		$tag_name = AutoHubsPagesHelper::getHubNameFromTitle($wgTitle);

		if ($isManager) {
			$temp = $datafeeds->getTopWikis($tag_id, $lang, 30, true, true);
			$temp['value'] = array_slice($temp['value'], 0, 30);
		} else {
			$temp = $datafeeds->getTopWikis($tag_id, $lang, 10, false);
			$temp['value'] = array_slice($temp['value'], 0, 10);
		}
		$this->hidetopwikis = false;
		$this->data['title'] = $wgTitle;
		$this->data['topWikis1'] = $temp['value'];
		$this->data['is_menager'] = $isManager;
	}

	public function executeTopHubUsers() {
		global $wgTitle;
		$datafeeds = new WikiaStatsAutoHubsConsumerDB(DB_SLAVE);

		$lang = AutoHubsPagesHelper::getLangForHub($wgTitle);
		$tag_id = AutoHubsPagesHelper::getHubIdFromTitle($wgTitle);

		$temp = $datafeeds->getTopUsers($tag_id, $lang, 5);
		foreach ($temp['value'] as &$value) {
			$value['avatar'] = AvatarService::renderAvatar($value['username'], 20);
		}
		$this->data['title'] = $wgTitle;
		$this->data['topEditors'] = $temp['value'];

	}

	public function executePopularHubPosts () {
		global $wgUser, $wgTitle, $wgStylePath, $wgEnableBlog;
		$isManager = $wgUser->isAllowed( 'corporatepagemanager' );
		$datafeeds = new WikiaStatsAutoHubsConsumerDB(DB_SLAVE);

		$lang = AutoHubsPagesHelper::getLangForHub($wgTitle);
		$tag_id = AutoHubsPagesHelper::getHubIdFromTitle($wgTitle);
		$tag_name = AutoHubsPagesHelper::getHubNameFromTitle($wgTitle);
		$this->hidetopblogs=false;
		if ($isManager) {
			$temp = $datafeeds->getTopBlogs($tag_id, $lang, 9, 3, true, true);
		} else {
			$temp = $datafeeds->getTopBlogs($tag_id, $lang, 3, 1);
		}
		$this->data['title'] = $wgTitle;
//		$this->data['topBlogs'] = $temp['value'];
		$this->data['is_menager'] = $isManager;

		$this->wgStylePath = $wgStylePath;
		$this->wgTitle = $wgTitle;

		// Swizzle data into format used by BlogListing template
		$posts = array();
		foreach ($temp['value'] as $value) {
			$post = array();
			$post['title'] = $value['title'];
			$post['namespace'] = $value['namespace'];
			$post['timestamp'] = $value['timestamp'];
			$post['date'] = $value['date'];
			$post['avatar'] = AvatarService::renderAvatar($value['author'], 48);
			$post['userpage'] = $value['real_pagename'];  // FIXME
			$post['username'] = $value['author'];
			$post['readmore'] = null;
			$post['text'] = $value['description'];
			$post['comments'] = $value['all_count'];
			$post['likes'] = null;
			$posts[] = $post;
		}

		$this->posts = $posts;

	}

	public function executePopularStaffPosts () {
		global $wgUser, $wgTitle, $wgParser, $wgEnableBlog;

		// http://community.wikia.com/api.php?action=query&list=categorymembers&cmtitle=Category:Staff_blogs&cmnamespace=500&cmsort=timestamp&cmdir=desc
		// FIXME: implement this
	}

	public function executeHotSpots () {
		global $wgUser, $wgTitle;

		$isManager = $wgUser->isAllowed( 'corporatepagemanager' );
		$datafeeds = new WikiaStatsAutoHubsConsumerDB(DB_SLAVE);

		$lang = AutoHubsPagesHelper::getLangForHub($wgTitle);
		$tag_id = AutoHubsPagesHelper::getHubIdFromTitle($wgTitle);
		$tag_name = AutoHubsPagesHelper::getHubNameFromTitle($wgTitle);

		if ($isManager) {
			$temp = $datafeeds->getTopArticles($tag_id, $lang, 15, 3, true, true);
		} else {
			$temp = $datafeeds->getTopArticles($tag_id, $lang, 5, 1);
		}

		$this->data['title'] = $wgTitle;
		$this->data['hotSpots'] = $temp['value'];
		$this->data['is_menager'] = $isManager;
	}
	
	public function executeSlider() {
		global $wgOut, $wgTitle, $wgStylePath;

		if (BodyModule::isHubPage()) {
			$this->slider_class = "small";
			$tag_name = AutoHubsPagesHelper::getHubNameFromTitle($wgTitle);
			$this->slider = CorporatePageHelper::parseMsgImg( 'hub-' . $tag_name . '-slider', true );
		}
		if (ArticleAdLogic::isMainPage()) {
			$this->slider_class = "big";
			$this->slider = CorporatePageHelper::parseMsgImg('corporatepage-slider',true);
		}
	}
}
?>
