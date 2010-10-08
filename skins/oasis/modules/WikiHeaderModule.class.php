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
	var $wordmarkFont;

	var $wgSingleH1;

	/**
	 * @author: Inez Korczyński
	 */
	private function parseMonacoSidebarToOasisNavigation($text) {
		$lines = explode("\n", $text);
		$skip = true;
		$firstDone = false;
		$new_lines = array();

		foreach($lines as $line) {
			if($skip) {
				if(trim($line) != '' && $line{0} == '*') {
					$depth = strrpos($line, '*') + 1;
					if($depth == 1) {
						if(!$firstDone) {
							$firstDone = true;
						} else {
							$skip = false;
						}
					}
				}
			}

			if(!$skip) {
				$new_lines[] = $line;
			}
		}

		return join("\n", $new_lines);
	}

	public function executeIndex() {

		global $wgOut, $wgCityId, $wgUser, $wgMemc;

		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->wordmarkText = $settings["wordmark-text"];
		$this->wordmarkType = $settings["wordmark-type"];
		$this->wordmarkSize = $settings["wordmark-font-size"];
		$this->wordmarkFont = $settings["wordmark-font"];

		if ($this->wordmarkType == "graphic") {
			$this->wordmarkStyle = 'style="background: url('. $settings["wordmark-image-url"] .') no-repeat"';
		} else {
			$this->wordmarkStyle = '';
		}

		$this->mainPageURL = Title::newMainPage()->getLocalURL();

		if($wgUser->isAllowed('editinterface')) {
			$this->editURL['href'] = Title::newFromText('Wiki-navigation', NS_MEDIAWIKI)->getFullURL();
			$this->editURL['text'] = wfMsg('monaco-edit-this-menu');
		}

		$service = new NavigationService();
		$this->menuNodes = $service->parseMessage('Wiki-navigation', array(4, 7), 60*60*3 /* 3 hours */, true);

	}

}
