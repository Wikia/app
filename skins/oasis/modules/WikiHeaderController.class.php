<?php

class WikiHeaderController extends WikiaController {

	public function executeIndex() {
		OasisController::addBodyClass('wikinav2');

		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->wordmarkText = $settings["wordmark-text"];
		$this->wordmarkType = $settings["wordmark-type"];
		$this->wordmarkSize = $settings["wordmark-font-size"];
		$this->wordmarkFont = $settings["wordmark-font"];

		if ($this->wordmarkType == "graphic") {
			wfProfileIn(__METHOD__ . 'graphicWordmarkV2');
			$this->wordmarkUrl = $themeSettings->getWordmarkUrl();
			$imageTitle = Title::newFromText($themeSettings::WordmarkImageName, NS_IMAGE);
			if ($imageTitle instanceof Title) {
				$attributes = array();
				$file = wfFindFile($imageTitle);
				if ($file instanceof File) {
					$attributes [] = 'width="' . $file->width . '"';
					$attributes [] = 'height="' . $file->height . '"';

					if (!empty($attributes)) {
						$this->wordmarkStyle = ' ' . implode(' ', $attributes) . ' ';
					}
				}
			}
			wfProfileOut(__METHOD__ . 'graphicWordmarkV2');
		}

		$this->mainPageURL = Title::newMainPage()->getLocalURL();

		$this->displaySearch = !empty($this->wg->EnableAdminDashboardExt) && AdminDashboardLogic::displayAdminDashboard($this, $this->wg->Title);
		$this->setVal( 'displayHeader', !$this->wg->HideNavigationHeaders );
	}

	public function executeWordmark() {
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->wordmarkText = $settings['wordmark-text'];
		$this->wordmarkType = $settings['wordmark-type'];
		$this->wordmarkSize = $settings['wordmark-font-size'];
		$this->wordmarkFont = $settings['wordmark-font'];
		$this->wordmarkFontClass = !empty($settings["wordmark-font"]) ? "font-{$settings['wordmark-font']}" : '';
		$this->wordmarkUrl = '';
		if ($this->wordmarkType == "graphic") {
			wfProfileIn(__METHOD__ . 'graphicWordmark');
			$this->wordmarkUrl = $themeSettings->getWordmarkUrl();
			$imageTitle = Title::newFromText($themeSettings::WordmarkImageName, NS_IMAGE);
			if ($imageTitle instanceof Title) {
				$attributes = array();
				$file = wfFindFile($imageTitle);
				if ($file instanceof File) {
					$attributes [] = 'width="' . $file->width . '"';
					$attributes [] = 'height="' . $file->height . '"';

					if (!empty($attributes)) {
						$this->wordmarkStyle = ' ' . implode(' ', $attributes) . ' ';
					}
				}
			}
			wfProfileOut(__METHOD__ . 'graphicWordmark');
		}

		$this->mainPageURL = Title::newMainPage()->getLocalURL();
	}
}
