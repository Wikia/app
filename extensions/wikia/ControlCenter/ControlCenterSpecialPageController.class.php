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
	
	/**
	 * @details
	 * 	SpecialPage::capturePath will skip SpecialPages which are not "includable" 
	 *	Which is like all of them. :)  So we need to force it
	 *  $output = SpecialPage::capturePath($title);
	 *  
	 * @requestParam string page the name of the Special page to invoke
	 * @responseParam string output the HTML output of the special page
	 */
	
	public function GetSpecialPage () {

		// Construct title object from request params
		$pageName = $this->request->getVal("page");
		$title = SpecialPage::getTitleFor($pageName);
		
		// Save global variables and initialize context for special page
		global $wgOut, $wgTitle;
		$oldTitle = $wgTitle;
		$oldOut = $wgOut;
		$wgOut = new OutputPage;
		$wgOut->setTitle( $title );
		$wgTitle = $title;
				
		// Construct special page object
		try {
			$sp = new $pageName(); 
		} catch (Exception $e) {
			print_pre("Could not construct special page object");
		}
		if ($sp instanceof SpecialPage) {
			$ret = $sp->execute(false);
		} else {
			print_pre("Object is not a special page.");
		}

		// TODO: check retval of special page call?
		
		$output = $wgOut->getHTML();
		
		// Restore global variables
		$wgTitle = $oldTitle;
		$wgOut = $oldOut;
		
		//print_pre($wgOut->getHTML());
		$this->response->setVal("output", $output);
		
	}

}