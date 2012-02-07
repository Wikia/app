<?php

class WikiHeaderModule extends Module {

	var $wgBlankImgUrl;
	var $wgEnableCorporatePageExt;

	var $mainPageURL;
	var $wgSitename;
	var $menuNodes;
	var $editURL;

	var $wordmarkText;
	var $wordmarkType;
	var $wordmarkSize;
	var $wordmarkStyle;
	var $wordmarkUrl;
	var $wordmarkFont;

	public function executeIndex() {
		global $wgOut, $wgCityId, $wgUser, $wgMemc, $wgIsPrivateWiki, $wgEnableAdminDashboardExt, $wgTitle;

		//fb#1090
		$this->isInternalWiki = empty($wgCityId);
		$this->showMenu = !(($this->isInternalWiki || $wgIsPrivateWiki) && $wgUser->isAnon());

		if($wgUser->isAllowed('editinterface')) {
			$this->editURL['href'] = Title::newFromText('Wiki-navigation', NS_MEDIAWIKI)->getFullURL();
			$this->editURL['text'] = wfMsg('oasis-edit-this-menu');
		}

		$service = new NavigationService();
		$this->menuNodes = $service->parseMessage('Wiki-navigation', array(4, 7, 7), 60*60*3 /* 3 hours */, true);

		$this->displaySearch = !empty($wgEnableAdminDashboardExt) && AdminDashboardLogic::displayAdminDashboard(F::app(), $wgTitle);
	}

	public function executeWordmark() {
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->wordmarkText = $settings['wordmark-text'];
		$this->wordmarkType = $settings['wordmark-type'];
		$this->wordmarkSize = $settings['wordmark-font-size'];
		$this->wordmarkFont = $settings['wordmark-font'];
		$this->wordmarkFontClass = !empty($settings["wordmark-font"]) ? "font-{$settings['wordmark-font']}" : '';

		if ($this->wordmarkType == "graphic") {
			$this->wordmarkUrl = wfReplaceImageServer($settings['wordmark-image-url'], SassUtil::getCacheBuster());
			//$this->wordmarkStyle = 'style="background: url('. $wordmarkUrl .') no-repeat"';
		} else {
			//$this->wordmarkStyle = '';
		}

		$this->mainPageURL = Title::newMainPage()->getLocalURL();
	}
}