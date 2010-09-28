<?php
class FooterModule extends Module {

	var $wgBlankImgUrl;

	var $showLike;
	var $showShare;
	var $showFollow;
	var $showMyTools;
	var $follow;
	var $showToolbar;
	var $showNotifications;

	var $wgSingleH1;

	public function executeIndex() {
		global $wgTitle, $wgContentNamespaces, $wgUser, $wgSuppressToolbar, $wgShowMyToolsOnly, $wgSingleH1;

		// don't show toolbar when wgSuppressToolbar is set (for instance on edit pages)
		$this->showToolbar = empty($wgSuppressToolbar);
		if ($this->showToolbar == false) {
			return;
		}

		// show only "My Tools" dropdown on toolbar
		if (!empty($wgShowMyToolsOnly)) {
			$this->showMyTools = true;
			return;
		}

		if(isset(self::$skinTemplateObj->data['content_actions']['watch'])) {
			$this->follow = self::$skinTemplateObj->data['content_actions']['watch'];
			$this->follow['action'] = 'watch';
		} else if(isset(self::$skinTemplateObj->data['content_actions']['unwatch'])) {
			$this->follow = self::$skinTemplateObj->data['content_actions']['unwatch'];
			$this->follow['action'] = 'unwatch';
		}

		$this->showNotifications = true;

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

		} else if($wgTitle->isTalkPage() || $namespace == NS_USER_TALK) {

			// article talk page
			// user talk page

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

		//} else if($namespace == NS_MEDIAWIKI || $namespace == NS_CATEGORY || $namespace == NS_MAIN || $namespace == NS_USER) {
		} else {

			// default
			// main page
			// user pages
			// category pages
			// mediawiki pages

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