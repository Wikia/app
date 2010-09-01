<?php

class ThemeSettings {
	private $settings;

	function __construct() {
		$this->load();

		// use default settings
		if (empty($this->settings)) {
			$this->settings = self::getDefaultSettings();
			wfDebug(__METHOD__ . ": using default settings - " . Wikia::json_encode($this->settings) . "\n");
		}
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

	private function load() {

	}

	public function save() {

	}
}