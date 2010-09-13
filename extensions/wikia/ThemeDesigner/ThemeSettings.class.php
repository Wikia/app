<?php

class ThemeSettings {
	const WikiFactorySettings = 'wgOasisThemeSettings';
	const WikiFactoryHistory = 'wgOasisThemeSettingsHistory';

	const HistoryItemsLimit = 10;

	private $settings;

	function __construct() {
		wfProfileIn( __METHOD__ );

		$this->load();

		// use default settings
		if ( empty( $this->settings ) ) {
			$this->settings = self::getDefaultSettings();
			wfDebug( __METHOD__ . ": using default settings\n" );
		}

		wfProfileOut( __METHOD__ );
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

		// main page banner
		$settings['banner-image'] = false;
		$settings['banner-image-revision'] = false;

		// background
		$settings['background-image'] = false;
		$settings['background-image-revision'] = false;
		$settings['background-tiled'] = false;

		return $settings;
	}

	public function get( $name ) {
		return isset( $this->settings[$name] ) ? $this->settings[$name] : null;
	}

	public function getAll() {
		return $this->settings;
	}

	public function set( $name, $value ) {
		$this->settings[$name] = $value;
	}

	/**
	 * Return recent versions for theme settings
	 */
	public function getHistory() {
		if ( !empty( $GLOBALS[self::WikiFactoryHistory] ) ) {
			$history = $GLOBALS[self::WikiFactoryHistory];
		}
		else {
			$history = array();
		}

		return $history;
	}

	/**
	 * Try to load theme settings from WikiFactory variable
	 */
	private function load() {
		if ( !empty( $GLOBALS[self::WikiFactorySettings] ) ) {
			$this->settings = $GLOBALS[self::WikiFactorySettings];
			wfDebug( __METHOD__ . ": settings loaded from WF variable\n" );
		}
	}

	/**
	 * Save current settings to WikiFactory variable and update history
	 */
	public function save() {
		wfProfileIn( __METHOD__ );
		global $wgCityId, $wgUser;

		$data = $this->getAll();

		if(strpos($data['wordmark-image'], 'Temp_file_') === 0) {

			$temp_file = new LocalFile(Title::newFromText($data['wordmark-image'], 6), RepoGroup::singleton()->getLocalRepo());

			$file = new LocalFile(Title::newFromText('Oasis-wordmark-A.png', 6), RepoGroup::singleton()->getLocalRepo());
			$file->upload($temp_file->getPath(), '', '');
			$data['wordmark-image'] = $file->getURL();

			$temp_file->delete('');

			$history = $file->getHistory(1);

			if(count($history) == 1) {
				$oldUrl = $history[0]->getURL();
			}

		}

		$reason = 'Theme Designer - save done by ' . $wgUser->getName();

		// update WF variable with current theme settings
		$result = WikiFactory::setVarByName(self::WikiFactorySettings, $wgCityId, $data, $reason);
		if(!$result) {
			wfDebug( __METHOD__ . ": save has failed!\n" );
			return false;
		}

		// update history
		if(!empty($GLOBALS[self::WikiFactoryHistory])) {
			$history = $GLOBALS[self::WikiFactoryHistory];

			$lastItem = end($history);
			$revisionId = intval($lastItem['revision']) + 1;
		} else {
			$history = array();
			$revisionId = 1;
		}

		// add entry
		$history[] = array(
			'settings' => $data,
			'author' => $wgUser->getName(),
			'timestamp' =>  wfTimestampNow(),
			'revision' => $revisionId,
		);

		// limit history size to last 10 changes
		$history = array_slice($history, -self::HistoryItemsLimit);

		if(count($history) > 1 && isset($oldUrl)) {
			$history[count($history)-2]['settings']['wordmark-image'] = $oldUrl;
		}

		$result = WikiFactory::setVarByName(self::WikiFactoryHistory, $wgCityId, $history, $reason);
		if(!$result) {
			wfDebug(__METHOD__ . ": history save has failed!\n");
			return false;
		}

		wfDebug(__METHOD__ . ": settings saved as #{$revisionId}\n");

		wfProfileOut( __METHOD__ );
		return true;
	}
}