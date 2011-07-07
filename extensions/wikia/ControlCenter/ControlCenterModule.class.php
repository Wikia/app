<?php

class ControlCenterModule extends Module {
	
	var $wordmarkText;
	var $wordmarkType;
	var $wordmarkSize;
	
	// Render the control center chrome
	public function executeChrome () {
		global $wgRequest;
		$this->tab = $wgRequest->getVal("tab", "");

		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/ControlCenter/css/ControlCenter.scss', null, $this->getAlternateOasisSetting()));
		$this->wg->Out->addScriptFile($this->wg->ExtensionsPath . '/wikia/ControlCenter/js/ControlCenter.js');
		
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->wordmarkText = $settings['wordmark-text'];
		$this->wordmarkType = $settings['wordmark-type'];
		$this->wordmarkSize = $settings['wordmark-font-size'];

		if ($this->wordmarkType == 'graphic') {
			$this->wordmarkUrl = wfReplaceImageServer($settings['wordmark-image-url'], SassUtil::getCacheBuster());
		}

		$this->founderProgressBar = (string)F::app()->sendRequest( 'FounderProgressBar', 'widget' );
		
		$this->controlCenterUrlGeneral = Title::newFromText('AdminDashboard', NS_SPECIAL)->getFullURL().'?tab=general';
		$this->controlCenterUrlAdvanced = Title::newFromText('AdminDashboard', NS_SPECIAL)->getFullURL().'?tab=advanced';
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
