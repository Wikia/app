<?php
class ThemeDesignerModule extends Module {

	var $wgCdnRootUrl;
	var $wgExtensionsPath;
	var $wgStylePath;

	var $wgServer;
	var $dir;
	var $mimetype;
	var $charset;

	var $themeSettings;

	public function executeIndex() {
		$this->themeSettings = new ThemeSettings();

		// for tests
		#$this->themeSettings->save();
	}

	public function executeThemeTab() {

	}

	public function executeCustomizeTab() {

	}

	public function executeWordmarkTab() {

	}

	public function executeBannerTab() {

	}

}
