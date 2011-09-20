<?php

class WikiHeaderV2Module extends Module {

	var $wgBlankImgUrl;
	var $wgEnableCorporatePageExt;

	var $mainPageURL;
	var $wgSitename;

	var $wordmarkText;
	var $wordmarkType;
	var $wordmarkSize;
	var $wordmarkUrl;
	var $wordmarkFont;

	public function executeIndex() {
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->wordmarkText = $settings["wordmark-text"];
		$this->wordmarkType = $settings["wordmark-type"];
		$this->wordmarkSize = $settings["wordmark-font-size"];
		$this->wordmarkFont = $settings["wordmark-font"];

		if ($this->wordmarkType == "graphic") {
			$this->wordmarkUrl = wfReplaceImageServer($settings['wordmark-image-url'], SassUtil::getCacheBuster());
		}

		$this->mainPageURL = Title::newMainPage()->getLocalURL();
	}
}