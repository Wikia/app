<?php

class AdminDashboardModule extends Module {
	
	var $wordmarkText;
	var $wordmarkType;
	var $wordmarkSize;
	var $adminDashboardUrlGeneral;
	var $adminDashboardUrlAdvanced;
	
	// Render the Admin Dashboard chrome
	public function executeChrome () {
		global $wgRequest, $wgTitle;
		
		$adminDashboardTitle = Title::newFromText('AdminDashboard', NS_SPECIAL);
		$isAdminDashboard = $wgTitle->getText() == $adminDashboardTitle->getText();
		
		$this->tab = $wgRequest->getVal("tab", "");
		if(empty($this->tab) && $isAdminDashboard) {
			$this->tab = 'general';
		}

		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/AdminDashboard/css/AdminDashboard.scss', null, $this->getAlternateOasisSetting()));
		$this->wg->Out->addScriptFile($this->wg->ExtensionsPath . '/wikia/AdminDashboard/js/AdminDashboard.js');
		
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->wordmarkText = $settings['wordmark-text'];
		$this->wordmarkType = $settings['wordmark-type'];
		$this->wordmarkSize = $settings['wordmark-font-size'];

		if ($this->wordmarkType == 'graphic') {
			$this->wordmarkUrl = wfReplaceImageServer($settings['wordmark-image-url'], SassUtil::getCacheBuster());
		}
		
		$this->adminDashboardUrlGeneral = Title::newFromText('AdminDashboard', NS_SPECIAL)->getFullURL().'?tab=general';
		$this->adminDashboardUrlAdvanced = Title::newFromText('AdminDashboard', NS_SPECIAL)->getFullURL().'?tab=advanced';
		
		$this->mainPageUrl = wfMsgForContent( 'mainpage' );
		
		$state = F::app()->sendRequest( 'AdminDashboardSpecialPage', 'getDrawerState', array())->getData();
		$this->hideRail = ($state['state'] != 'true') && !$isAdminDashboard;
	}
	
	/**
	 *	Copied and modified from SassUtil's getOasisSettings.  Load default oasis settings.
	 */
	private function getAlternateOasisSetting() {
		global $wgOasisThemes, $wgUser, $wgAdminSkin, $wgRequest, $wgOasisThemeSettings, $wgContLang, $wgABTests;
		wfProfileIn(__METHOD__);

		// Load the 5 deafult colors by theme here (eg: in case the wiki has an override but the user doesn't have overrides).
		static $oasisSettings = array();

		if (!empty($oasisSettings)) {
			wfProfileOut(__METHOD__);
			return $oasisSettings;
		}

		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();
		$oasisSettings["background-image"] = wfReplaceImageServer($settings['background-image'], SassUtil::getCacheBuster());
		$oasisSettings["background-align"] = $settings["background-align"];
		$oasisSettings["background-tiled"] = $settings["background-tiled"];
		$oasisSettings["background-fixed"] = $settings["background-fixed"];
		if (isset($settings["wordmark-font"]) && $settings["wordmark-font"] != "default") {
			$oasisSettings["wordmark-font"] = $settings["wordmark-font"];
		}

		// RTL
		if($wgContLang && $wgContLang->isRTL()){
			$oasisSettings['rtl'] = 'true';
		}

		// RT:70673
		foreach ($oasisSettings as $key => $val) {
			if(!empty($val)) {
				$oasisSettings[$key] = trim($val);
			}
		}

		wfDebug(__METHOD__ . ': ' . Wikia::json_encode($oasisSettings) . "\n");

		wfProfileOut(__METHOD__);
		return $oasisSettings;
	}
}
