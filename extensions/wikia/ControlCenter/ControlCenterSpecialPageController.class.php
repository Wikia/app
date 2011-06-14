<?php

/**
 * This is an example use of SpecialPage controller
 * @author ADi
 *
 */
class ControlCenterSpecialPageController extends WikiaSpecialPageController {

	public function __construct() {
		wfLoadExtensionMessages('ControlCenter');
		parent::__construct('ControlCenter', '', false);
	}

	public function index() {
		/*
		$wgSuppressWikiHeader = $this->app->getGlobal('wgSuppressWikiHeader');
		$wgSuppressPageHeader = $this->app->getGlobal('wgSuppressPageHeader');
		$wgSuppressFooter = $this->app->getGlobal('wgSuppressFooter');
		$wgSuppressAds = $this->app->getGlobal('wgSuppressAds');
		$wgSuppressToolbar = $this->app->getGlobal('wgSuppressToolbar');
		*/
		global $wgSuppressWikiHeader, $wgSuppressPageHeader, $wgSuppressFooter, $wgSuppressAds, $wgSuppressToolbar, $wgOut;
		
		//$wgOut->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/ControlCenter/css/ControlCenter.scss'));
		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/ControlCenter/css/ControlCenter.scss'));
		$this->wg->Out->addScriptFile($this->wg->ExtensionsPath . '/wikia/ControlCenter/js/ControlCenter.js');
		
		
		// hide some default oasis UI things
		$wgSuppressWikiHeader = true;
		$wgSuppressPageHeader = true;
		//$wgSuppressFooter = true;
		$wgSuppressAds = true;
		//$wgSuppressToolbar = true;
		
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$wordmarkText = $settings['wordmark-text'];
		$wordmarkType = $settings['wordmark-type'];
		$wordmarkSize = $settings['wordmark-font-size'];
		$this->response->setVal('wordmarkText', $wordmarkText);
		$this->response->setVal('wordmarkType', $wordmarkType);
		$this->response->setVal('wordmarkSize', $wordmarkSize);

		if ($wordmarkType == 'graphic') {
			$wordmarkUrl = wfReplaceImageServer($settings['wordmark-image-url'], SassUtil::getCacheBuster());
			$this->response->setVal('wordmarkUrl', $wordmarkUrl);
		}
		
	}

}