<?php

class AdminDashboardModule extends Module {
	
	var $wordmarkText;
	var $wordmarkType;
	var $wordmarkSize;
	var $tab;
	var $adminDashboardUrl;
	var $adminDashboardUrlGeneral;
	var $adminDashboardUrlAdvanced;
	
	// Render the Admin Dashboard chrome
	public function executeChrome () {
		global $wgRequest, $wgTitle;
		
		$adminDashboardTitle = Title::newFromText('AdminDashboard', NS_SPECIAL);
		$this->isAdminDashboard = $wgTitle->getText() == $adminDashboardTitle->getText();
		
		$this->tab = $wgRequest->getVal("tab", "");
		if(empty($this->tab) && $this->isAdminDashboard) {
			$this->tab = 'general';
		} else if(AdminDashboardLogic::isGeneralApp($wgTitle->getDBKey())) {
			$this->tab = 'general';
		} else if(empty($this->tab)) {
			$this->tab = 'advanced';
		}

		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/AdminDashboard/css/AdminDashboard.scss', null, $this->getAlternateOasisSetting()));
		$this->wg->Out->addScriptFile($this->wg->ExtensionsPath . '/wikia/AdminDashboard/js/AdminDashboard.js');
		
		$this->adminDashboardUrl = Title::newFromText('AdminDashboard', NS_SPECIAL)->getFullURL("tab=$this->tab");
		$this->adminDashboardUrlGeneral = Title::newFromText('AdminDashboard', NS_SPECIAL)->getFullURL("tab=general");
		$this->adminDashboardUrlAdvanced = Title::newFromText('AdminDashboard', NS_SPECIAL)->getFullURL("tab=advanced");
		
	}
	
	/**
	 *	Copied and modified from SassUtil's getOasisSettings.  Load default oasis settings.
	 */
	private function getAlternateOasisSetting() {
		global $wgOasisThemes, $wgUser, $wgAdminSkin, $wgRequest, $wgOasisThemeSettings, $wgContLang, $wgABTests, $wgRequest;
		wfProfileIn(__METHOD__);

		// Load the 5 deafult colors by theme here (eg: in case the wiki has an override but the user doesn't have overrides).
		static $oasisSettings = array();

		if (!empty($oasisSettings)) {
			wfProfileOut(__METHOD__);
			return $oasisSettings;
		}

		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();
		$oasisSettings["color-body"] = SassUtil::sanitizeColor($settings["color-body"]);
		
		$useTheme = $wgRequest->getVal('use_theme', 0);	// use_theme=1, oasis otherwise
		if(!empty($useTheme)) {
			$oasisSettings["use-theme"] = "true";
			$oasisSettings["color-page"] = SassUtil::sanitizeColor($settings["color-page"]);
			$oasisSettings["color-buttons"] = SassUtil::sanitizeColor($settings["color-buttons"]);
			$oasisSettings["color-links"] = SassUtil::sanitizeColor($settings["color-links"]);
			$oasisSettings["color-header"] = SassUtil::sanitizeColor($settings["color-header"]);
		}
		
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
