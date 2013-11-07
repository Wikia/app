<?php

class ThemeSettings {

	const WikiFactorySettings = 'wgOasisThemeSettings';

	const WikiFactoryHistory = 'wgOasisThemeSettingsHistory';

	const HistoryItemsLimit = 10;

	const WordmarkImageName = 'Wiki-wordmark.png';
	const BackgroundImageName = 'Wiki-background';
	const FaviconImageName = 'Favicon.ico';

	private $defaultSettings;

	function __construct() {
		global $wgOasisThemes, $wgSitename, $wgAdminSkin;

		$themeName = 'oasis';

		$adminSkin = explode('-', $wgAdminSkin);

		if(count($adminSkin) == 2) {
			$transition = array(
				'sky' => 'oasis',
				'sapphire' => 'oasis',
				'spring' => 'jade',
				'forest' => 'jade',
				'obsession' => 'carbon',
				'moonlight' => 'bluesteel',
				'beach' => 'creamsicle',
			);

			if(isset($transition[$adminSkin[1]])) {
				$themeName = $transition[$adminSkin[1]];
			}
		}

		// colors
		$this->defaultSettings = $wgOasisThemes[$themeName];
		$this->defaultSettings['theme'] = $themeName;

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
		$this->defaultSettings['background-image-height'] = null;
		$this->defaultSettings['background-image-name'] = '';
		$this->defaultSettings['background-image-width'] = null;
		$this->defaultSettings['background-image-revision'] = false; //what is this?
		$this->defaultSettings['background-tiled'] = false;
		$this->defaultSettings['background-fixed'] = false;
		$this->defaultSettings['background-align'] = "center";
	}

	public function getSettings() {
		$settings = $this->defaultSettings;
		if(!empty($GLOBALS[self::WikiFactorySettings])) {
			$settings = array_merge($settings, $GLOBALS[self::WikiFactorySettings]);
			$colorKeys = array( "color-body", "color-page", "color-buttons", "color-links", "color-header" );

			// if any of the user set colors are invalid, use default
			foreach ($colorKeys as $colorKey) {
				if (!ThemeDesignerHelper::isValidColor($settings[$colorKey])) {
					$settings = $this->defaultSettings;
					break;
				}
			}

			// add variables that might not be saved already in WF
			if(!isset($settings['background-fixed'])) {
				$settings['background-fixed'] = false;
			}
			if(!isset($settings['page-opacity'])) {
				$settings['page-opacity'] = 100;
			}
		}

		return $settings;
	}

	public function getFreshURL($name, $definedName) {
		$title = Title::newFromText($definedName, NS_FILE);
		if( $definedName != $name ) {
			$file = OldLocalFile::newFromArchiveName($title, RepoGroup::singleton()->getLocalRepo(), $name);
			return wfReplaceImageServer($file->getUrl());
		} else {
			$file = new LocalFile($title, RepoGroup::singleton()->getLocalRepo());
			return wfReplaceImageServer($file->getUrl());
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

		foreach($history as $key => $val) {
			$history[$key]['settings']['background-image'] = $this->getFreshURL($val['settings']['background-image-name'], ThemeSettings::BackgroundImageName);
		}

		return $history;
	}

	public function saveSettings($settings, $cityId = null) {
		global $wgCityId, $wgUser;
		$cityId = empty($cityId) ? $wgCityId : $cityId;

		if(isset($settings['favicon-image-name']) && strpos($settings['favicon-image-name'], 'Temp_file_') === 0) {
			$temp_file = new LocalFile(Title::newFromText($settings['favicon-image-name'], 6), RepoGroup::singleton()->getLocalRepo());
			$file = new LocalFile(Title::newFromText(self::FaviconImageName, 6), RepoGroup::singleton()->getLocalRepo());
			$file->upload($temp_file->getPath(), '', '');
			$temp_file->delete('');

			$settings['favicon-image-url'] = $file->getURL();
			$settings['favicon-image-name'] = $file->getName();

			$file->repo->forceMaster();
			$history = $file->getHistory(1);
			if(count($history) == 1) {
				$oldFaviconFile = array('url' => $history[0]->getURL(), 'name' => $history[0]->getArchiveName());
			}
		}

		if(isset($settings['wordmark-image-name']) && strpos($settings['wordmark-image-name'], 'Temp_file_') === 0) {
			$temp_file = new LocalFile(Title::newFromText($settings['wordmark-image-name'], 6), RepoGroup::singleton()->getLocalRepo());
			$file = new LocalFile(Title::newFromText(self::WordmarkImageName, 6), RepoGroup::singleton()->getLocalRepo());
			$file->upload($temp_file->getPath(), '', '');
			$temp_file->delete('');

			$settings['wordmark-image-url'] = $file->getURL();
			$settings['wordmark-image-name'] = $file->getName();

			$file->repo->forceMaster();
			$history = $file->getHistory(1);
			if(count($history) == 1) {
				$oldFile = array('url' => $history[0]->getURL(), 'name' => $history[0]->getArchiveName());
			}
		}

		if(isset($settings['background-image-name']) && strpos($settings['background-image-name'], 'Temp_file_') === 0) {
			$temp_file = new LocalFile(Title::newFromText($settings['background-image-name'], 6), RepoGroup::singleton()->getLocalRepo());
			$file = new LocalFile(Title::newFromText(self::BackgroundImageName, 6), RepoGroup::singleton()->getLocalRepo());
			$file->upload($temp_file->getPath(), '', '');
			$temp_file->delete('');

			$settings['background-image'] = $file->getURL();
			$settings['background-image-name'] = $file->getName();
			$settings['background-image-width'] = $file->getWidth();
			$settings['background-image-height'] = $file->getHeight();

			$imageServing = new ImageServing(null, 120, array("w"=>"120", "h"=>"100"));
			$settings['user-background-image'] = $file->getURL();
			$settings['user-background-image-thumb'] = wfReplaceImageServer($file->getThumbUrl( $imageServing->getCut($file->getWidth(), $file->getHeight(), "origin")."-".$file->getName()));

 			$file->repo->forceMaster();
			$history = $file->getHistory(1);
			if(count($history) == 1) {
				$oldBackgroundFile = array('url' => $history[0]->getURL(), 'name' => $history[0]->getArchiveName());
			}
		}

		$reason = wfMsg( 'themedesigner-reason', $wgUser->getName() );

		// update history
		if(!empty($GLOBALS[self::WikiFactoryHistory])) {
			$history = $GLOBALS[self::WikiFactoryHistory];
			$lastItem = end($history);
			$revisionId = intval($lastItem['revision']) + 1;
		} else {
			$history = array();
			$revisionId = 1;
		}

		// #140758 - Jakub
		// validation
		// default color values
		foreach ( ThemeDesignerHelper::getColorVars() as $sColorVar => $sDefaultValue ){
			if ( !isset( $settings[ $sColorVar ] ) || !ThemeDesignerHelper::isValidColor( $settings[ $sColorVar ] ) ){
				$settings[ $sColorVar ] = $sDefaultValue;
			}
		}

		// update WF variable with current theme settings
		WikiFactory::setVarByName(self::WikiFactorySettings, $cityId, $settings, $reason);

		// add entry
		$history[] = array(
			'settings' => $settings,
			'author' => $wgUser->getName(),
			'timestamp' =>  wfTimestampNow(),
			'revision' => $revisionId,
		);

		// limit history size to last 10 changes
		$history = array_slice($history, -self::HistoryItemsLimit);

		if(count($history) > 1 ) {
			for($i = 0; $i < count($history) - 1; $i++) {
				if (isset($oldFaviconFile) && isset($history[$i]['settings']['favicon-image-name'])) {
					if($history[$i]['settings']['favicon-image-name'] == self::FaviconImageName) {
						$history[$i]['settings']['favicon-image-name'] = $oldFaviconFile['name'];
						$history[$i]['settings']['favicon-image-url'] = $oldFaviconFile['url'];
					}
				}
				if (isset($oldFile) && isset($history[$i]['settings']['wordmark-image-name'])) {
					if($history[$i]['settings']['wordmark-image-name'] == self::WordmarkImageName) {
						$history[$i]['settings']['wordmark-image-name'] = $oldFile['name'];
						$history[$i]['settings']['wordmark-image-url'] = $oldFile['url'];
					}
				}
				if (isset($oldBackgroundFile) && isset($history[$i]['settings']['background-image-name'])) {
					if($history[$i]['settings']['background-image-name'] == self::BackgroundImageName) {
						$history[$i]['settings']['background-image-name'] = $oldBackgroundFile['name'];
					}
				}
			}
		}

		WikiFactory::setVarByName(self::WikiFactoryHistory, $cityId, $history, $reason);
	}

	/**
	 * Get wordmark full, up-to-date URL
	 *
	 * This method returns URL based on "wordmark-image-name" settings entry.
	 * "wordmark-image-url" entry and settings revision ID are ignored.
	 *
	 * @author macbre
	 * @return string|bool wordmark URL or false if not found
	 */
	public function getWordmarkUrl() {
		$title = Title::newFromText($this->getSettings()['wordmark-image-name'] , NS_FILE);
		$file = ($title instanceof Title) ? wfFindFile($title) : false;

		return ($file instanceof File) ? $file->getUrl() : false;
	}

	/**
	 * Get wiki background full, up-to-date URL
	 *
	 * This method returns URL based on "background-image-name" settings entry.
	 * "background-image" entry (for custom backgrounds) and settings revision ID are ignored.
	 *
	 * @author macbre
	 * @return string|bool wordmark URL or false if not found
	 */
	public function getBackgroundUrl() {
		$settings = $this->getSettings();
		$hasCustomBackground = $settings['background-image-name'] !== '';

		// return standard, themed background - e.g. '/skins/oasis/images/themes/plated.jpg'
		if (!$hasCustomBackground) {
			return $settings['background-image'];
		}

		$title = Title::newFromText($this->getSettings()['background-image-name'] , NS_FILE);
		$file = ($title instanceof Title) ? wfFindFile($title) : false;

		return ($file instanceof File) ? $file->getUrl() : false;
	}
}
