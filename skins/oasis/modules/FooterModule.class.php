<?php
class FooterModule extends Module {

	var $wgBlankImgUrl;

	var $showLike;
	var $showShare;
	var $showFollow;
	var $showMyTools;
	var $follow;
	var $showToolbar;

	public function executeIndex() {
		global $wgTitle, $wgContentNamespaces, $wgUser;

		// don't show toolbar on edit pages
		$this->showToolbar = !BodyModule::isEditPage();
		if ($this->showToolbar == false) {
			return;
		}

		if(isset(self::$skinTemplateObj->data['content_actions']['watch'])) {
			$this->follow = self::$skinTemplateObj->data['content_actions']['watch'];
			$this->follow['action'] = 'watch';
		} else if(isset(self::$skinTemplateObj->data['content_actions']['unwatch'])) {
			$this->follow = self::$skinTemplateObj->data['content_actions']['unwatch'];
			$this->follow['action'] = 'unwatch';
		}

		$namespace = $wgTitle->getNamespace();

		if(false) {

			/*
			global $wgRequest;
			$action = $wgRequest->getVal('action');
			if($action == 'edit' || $action == 'submit') {
			}
			*/

		} else if(in_array($namespace, $wgContentNamespaces)) {

			// content namespaces

			$this->showLike = true;
			$this->showShare = true;
			$this->showFollow = true;
			$this->showMyTools = true;

		} else if($wgTitle->isTalkPage()) {

			// article talk page

			$this->showFollow = true;
			$this->showMyTools = true;

		} else if($namespace == NS_USER) {

			// user page

			$this->showLike = true;
			$this->showShare = true;
			$this->showFollow = true;
			$this->showMyTools = true;

		} else if(false) {

			// main page

			$this->showLike = true;
			$this->showShare = true;
			$this->showFollow = true;
			$this->showMyTools = true;

		} else if($namespace == NS_USER_TALK) {

			// user talk page

			$this->showFollow = true;
			$this->showMyTools = true;

		} else if($namespace == NS_CATEGORY) {

			// category page

			$this->showLike = true;
			$this->showShare = true;
			$this->showFollow = true;
			$this->showMyTools = true;


		} else if(defined('NS_BLOG_ARTICLE') && $namespace == NS_BLOG_ARTICLE) {

			// blog post page and user blog listing page

			if(!$wgTitle->isSubpage()) {
				$this->showLike = true;
			}
			$this->showShare = true;
			$this->showFollow = true;
			$this->showMyTools = true;

		} else if(defined('NS_BLOG_LISTING') && $namespace == NS_BLOG_LISTING) {

			// blog listing

			$this->showShare = true;
			$this->showFollow = true;
			$this->showMyTools = true;

		} else if($namespace == NS_SPECIAL) {

			// special pages

			$this->showShare = true;
			$this->showMyTools = true;

		} else if($namespace == NS_TEMPLATE) {

			// template pages

			$this->showShare = true;
			$this->showFollow = true;
			$this->showMyTools = true;

		} else if($namespace == NS_MEDIAWIKI) {

			// mediawiki pages

			$this->showLike = true;
			$this->showShare = true;
			$this->showFollow = true;
			$this->showMyTools = true;

		} else {

			// default

			$this->showLike = true;
			$this->showShare = true;
			$this->showFollow = true;
			$this->showMyTools = true;

		}

		if($wgUser->isAnon()) {
			$this->showMyTools = false;
		}
	}

}