<?php

namespace CommunityHeader;

use \ThemeSettings;
use \Title;

class Sitename {
	public $url;
	public $titleText;

	public function __construct() {
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->titleText = new Label( $settings['wordmark-text'] );
		$this->url = Title::newMainPage()->getLocalURL();
	}
}
