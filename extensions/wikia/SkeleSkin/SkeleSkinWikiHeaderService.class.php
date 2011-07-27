<?php

class  SkeleSkinWikiHeaderService extends WikiaService {
	
	public function index() {
	
		$themeSettings = F::build('ThemeSettings');
		$settings = $themeSettings->getSettings();

		$this->wordmarkText = $settings["wordmark-text"];
		$this->setVal( 'wordmarkText', $settings["wordmark-text"] );
		$this->wordmarkType = $settings["wordmark-type"];
		$this->wordmarkSize = $settings["wordmark-font-size"];
		$this->wordmarkFont = $settings["wordmark-font"];

	}

}
