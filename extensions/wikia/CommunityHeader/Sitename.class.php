<?php

namespace CommunityHeader;

use \ThemeSettings;
use \Title;

class Sitename {
	public $mainPageURL;
	public $titleText;

	public function __construct( $themeSettings ) {
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->titleText = new Label( $settings['wordmark-text'] );
		$this->mainPageURL = Title::newMainPage()->getLocalURL();
	}
}
