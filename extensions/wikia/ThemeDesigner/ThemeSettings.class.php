<?php

class ThemeSettings {

	const WikiFactorySettings = 'wgOasisThemeSettings';

	const WikiFactoryHistory = 'wgOasisThemeSettingsHistory';

	const HistoryItemsLimit = 10;

	const WordmarkImageName = 'Oasis-wordmark.png';

	private $defaultSettings;

	function __construct() {
		global $wgOasisThemes, $wgSitename;

		$defaultThemeName = 'sapphire';

		// colors
		$this->defaultSettings = $wgOasisThemes[$defaultThemeName];
		$this->defaultSettings['theme'] = $defaultThemeName;

		// wordmark
		$this->defaultSettings['wordmark-text'] = $wgSitename;
		$this->defaultSettings['wordmark-color'] = $this->defaultSettings['color-links'];
		$this->defaultSettings['wordmark-font'] = '';
		$this->defaultSettings['wordmark-font-size'] = 'medium';
		$this->defaultSettings['wordmark-image-url'] = '';
		$this->defaultSettings['wordmark-image-name'] = '';
		$this->defaultSettings['wordmark-type'] = "text";

		// main page banner
		$this->defaultSettings['banner-image-url'] = '';
		$this->defaultSettings['banner-image-name'] = '';

		// background
		$this->defaultSettings['background-image'] = false;
		$this->defaultSettings['background-image-revision'] = false;
		$this->defaultSettings['background-tiled'] = false;
	}

	public function getSettings() {
		if(!empty($GLOBALS[self::WikiFactorySettings])) {
			return array_merge($this->defaultSettings, $GLOBALS[self::WikiFactorySettings]);
		} else {
			return $this->defaultSettings;
		}
	}

	public function getHistory() {
		if(!empty($GLOBALS[self::WikiFactoryHistory])) {
			$history = $GLOBALS[self::WikiFactoryHistory];
			foreach($history as &$entry) {
				$entry['settings'] = array_merge($this->defaultSettings, $entry['settings']);
			}
		} else {
			$history = array();
		}

		return $history;
	}

	public function saveSettings($settings) {
		global $wgCityId, $wgUser;

		if(strpos($settings['wordmark-image-name'], 'Temp_file_') === 0) {
			$temp_file = new LocalFile(Title::newFromText($settings['wordmark-image-name'], 6), RepoGroup::singleton()->getLocalRepo());
			$file = new LocalFile(Title::newFromText(self::WordmarkImageName, 6), RepoGroup::singleton()->getLocalRepo());
			$file->upload($temp_file->getPath(), '', '');
			$temp_file->delete('');

			$settings['wordmark-image-url'] = $file->getURL();
			$settings['wordmark-image-name'] = $file->getName();

			$history = $file->getHistory(1);
			if(count($history) == 1) {
				$oldFile = array('url' => $history[0]->getURL(), 'name' => $history[0]->getArchiveName());
			}
		}

		$reason = 'Theme Designer - save done by ' . $wgUser->getName();

		// update WF variable with current theme settings
		WikiFactory::setVarByName(self::WikiFactorySettings, $wgCityId, $settings, $reason);

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
			'settings' => $settings,
			'author' => $wgUser->getName(),
			'timestamp' =>  wfTimestampNow(),
			'revision' => $revisionId,
		);

		// limit history size to last 10 changes
		$history = array_slice($history, -self::HistoryItemsLimit);

		if(count($history) > 1 && isset($oldFile)) {
			for($i = 0; $i < count($history) - 1; $i++) {
				if($history[$i]['settings']['wordmark-image-name'] == self::WordmarkImageName) {
					$history[$i]['settings']['wordmark-image-name'] = $oldFile['name'];
					$history[$i]['settings']['wordmark-image-url'] = $oldFile['url'];
				}
			}
		}

		WikiFactory::setVarByName(self::WikiFactoryHistory, $wgCityId, $history, $reason);

	}

}