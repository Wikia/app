<?php
class ThemeDesignerModule extends Module {

	var $wgCdnRootUrl;
	var $wgExtensionsPath;
	var $wgScript;
	var $wgServer;
	var $wgStylePath;

	var $dir;
	var $mimetype;
	var $charset;

	var $themeSettings;
	var $themeHistory;

	public function executeIndex() {
		global $wgLang;

		$settings = new ThemeSettings();
		$settings->save(); // for tests

		// current settings
		$this->themeSettings = $settings->getAll();

		// recent versions
		$this->themeHistory = $settings->getHistory();

		// format time (for edits older than 30 days - show timestamp)
		foreach($this->themeHistory as &$entry) {
			$diff = time() - strtotime($entry['timestamp']);

			if ($diff < 30 * 86400) {
				$entry['timeago'] = wfTimeFormatAgo($entry['timestamp']);
			}
			else {
				$entry['timeago'] = $wgLang->date($entry['timestamp']);
			}
		}
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
