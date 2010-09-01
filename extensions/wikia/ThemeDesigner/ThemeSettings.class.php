<?php

class ThemeSettings {
	const WikiFactorySettings = 'wgOasisThemeSettings';
	const WikiFactoryHistory = 'wgOasisThemeSettingsHistory';

	private $settings;

	function __construct() {
		wfProfileIn(__METHOD__);

		$this->load();

		// use default settings
		if (empty($this->settings)) {
			$this->settings = self::getDefaultSettings();
			wfDebug(__METHOD__ . ": using default settings\n");
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Get default settings if none saved found
	 */
	private static function getDefaultSettings() {
		global $wgOasisThemes, $wgSitename;

		$defaultThemeName = 'sapphire';

		// get default oasis theme colors
		$settings = $wgOasisThemes[$defaultThemeName];
		$settings['theme'] = $defaultThemeName;

		// wordmark
		$settings['wordmark-text'] = $wgSitename;
		$settings['wordmark-color'] = $settings['color-links'];
		$settings['wordmark-font'] = '';
		$settings['wordmark-font-size'] = '';
		$settings['wordmark-image'] = false;
		$settings['wordmark-image-revision'] = false;

		// main page banner
		$settings['banner-image'] = false;
		$settings['banner-image-revision'] = false;

		// background
		$settings['background-image'] = false;
		$settings['background-image-revision'] = false;
		$settings['background-tiled'] = false;

		return $settings;
	}

	public function get($name) {
		return isset($this->settings[$name]) ? $this->settings[$name] : null;
	}

	public function getAll() {
		return $this->settings;
	}

	public function set($name, $value) {
		$this->settings[$name] = $value;
	}

	/**
	 * Try to load theme settings from WikiFactory variable
	 */
	private function load() {
		if (!empty($GLOBALS[self::WikiFactorySettings])) {
			$this->settings = $GLOBALS[self::WikiFactorySettings];
			wfDebug(__METHOD__ . ": settings loaded from WF variable\n");
		}
	}

	/**
	 * Save current settings to WikiFactory variable and update history
	 */
	public function save() {
		global $wgCityId, $wgUser;

		$data = $this->getAll();
		$reason = 'Theme Designer - save done by ' . $wgUser->getName();

		// update WF variable with current theme settings
		$result = WikiFactory::setVarByName(self::WikiFactorySettings, $wgCityId, $data, $reason);
		if (!$result) {
			wfDebug(__METHOD__ . ": save has failed!\n");
			return false;
		}

		// update history
		if (!empty($GLOBALS[self::WikiFactoryHistory])) {
			$history = $GLOBALS[self::WikiFactoryHistory];
		}
		else {
			$history = array();
		}

		// prepare history entry
		$entry = array(
			'settings' => $data,
			'author' => $wgUser->getName(),
			'timestamp' =>  wfTimestampNow(),
		);

		// add an entry and limit history size to last 10 changes
		array_unshift($history, $entry);
		$history = array_slice($history, 0, 10);

		$result = WikiFactory::setVarByName(self::WikiFactoryHistory, $wgCityId, $history, $reason);
		if (!$result) {
			wfDebug(__METHOD__ . ": history save has failed!\n");
			return false;
		}

		wfDebug(__METHOD__ . ": settings saved\n");
		return true;
	}
}