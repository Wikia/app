<?php

class ControlCenterModule extends Module {
	
	var $wordmarkText;
	var $wordmarkType;
	var $wordmarkSize;
	
	// Render the control center chrome
	public function executeChrome () {
		global $wgRequest;
		$this->tab = $wgRequest->getVal("tab", "");

		$this->wg->Out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/ControlCenter/css/ControlCenter.scss'));
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
		
		$this->controlCenterUrlGeneral = Title::newFromText('ControlCenter', NS_SPECIAL)->getFullURL().'?tab=general';
		$this->controlCenterUrlAdvanced = Title::newFromText('ControlCenter', NS_SPECIAL)->getFullURL().'?tab=advanced';
	}
	
}
