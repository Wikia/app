<?php

class ThemeSettings {
	private $settings;

	function __construct() {
		global $wgOasisThemes, $wgSitename;

		$this->load();

		// use default settings
		if (empty($this->settings)) {
			$defaultThemeName = 'sapphire';

			// get default oasis theme
			$this->settings = $wgOasisThemes[$defaultThemeName];
			$this->settings['theme'] = $defaultThemeName;

			// wordmark
			$this->settings['wordmark-text'] = $wgSitename;
			$this->settings['wordmark-color'] = $this->get('color-links');
			$this->settings['wordmark-font'] = '';
			$this->settings['wordmark-image'] = false;

			// main page banner
			$this->settings['banner-image'] = false;

			// background
			$this->settings['background-color'] = $this->get('color-body');
			$this->settings['background-image'] = false;
			$this->settings['background-tiled'] = false;

			wfDebug(__METHOD__ . ": using default settings\n");
			wfDebug(__METHOD__ . print_r($this->settings, true));
		}
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