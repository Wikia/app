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
	var $returnTo;

	public function executeIndex() {
		wfProfileIn(__METHOD__);
		global $wgLang;

		$settings = new ThemeSettings();

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

		// URL user should be redirected to when settings are saved
		if (isset($_SERVER['HTTP_REFERER'])) {
			$this->returnTo = $_SERVER['HTTP_REFERER'];
		}
		else {
			$this->returnTo = $this->wgScript;
		}

		wfProfileOut(__METHOD__);
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
