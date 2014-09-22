<?php

class LocalNavigationController extends WikiaController {

	const WORDMARK_MAX_WIDTH = 160;
	const WORDMARK_MAX_HEIGHT = 41;

	public function Index() {
		Wikia::addAssetsToOutput( 'local_navigation_scss' );
	}

	public function Wordmark() {

		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$wordmarkUrl = '';
		if ($settings['wordmark-type'] == 'graphic') {
			wfProfileIn(__METHOD__ . 'graphicWordmark');
			$wordmarkUrl = $themeSettings->getWordmarkUrl();
			wfProfileOut(__METHOD__ . 'graphicWordmark');
		}

		$mainPageURL = Title::newMainPage()->getLocalURL();
		$wordmarkFontClass = !empty($settings['wordmark-font']) ? 'font-' . $settings['wordmark-font']  : '';

		$this->response->setVal('mainPageURL', $mainPageURL);
		$this->response->setVal('wordmarkText', $settings['wordmark-text']);
		$this->response->setVal('wordmarkSize', $settings['wordmark-font-size']);
		$this->response->setVal('wordmarkFontClass', $wordmarkFontClass);
		$this->response->setVal('wordmarkUrl', $wordmarkUrl);
		$this->response->setVal('wordmarkMaxWidth', self::WORDMARK_MAX_WIDTH);
		$this->response->setVal('wordmarkMaxHeight', self::WORDMARK_MAX_HEIGHT);
	}
}
