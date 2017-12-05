<?php

class ThemeSettings {
	const IMAGES = [
		'background',
		'community-header-background',
		'favicon',
		'wordmark'
	];

	const WikiFactorySettings = 'wgOasisThemeSettings';

	const WikiFactoryHistory = 'wgOasisThemeSettingsHistory';

	const HistoryItemsLimit = 10;

	const MIN_WIDTH_FOR_SPLIT = 1030;
	const MIN_WIDTH_FOR_NO_SPLIT = 2000;

	// Keep in sync with $wds-community-header-background-height-small-breakpoint
	const COMMUNITY_HEADER_BACKGROUND_HEIGHT = 115;
	// Keep in sync with $wds-community-header-background-width-small-breakpoint
	const COMMUNITY_HEADER_BACKGROUND_WIDTH = 471;

	const WordmarkImageName = 'Wiki-wordmark.png';
	const BackgroundImageName = 'Wiki-background';
	const CommunityHeaderBackgroundImageName = 'Community-header-background';
	const FaviconImageName = 'Favicon.ico';

	private $cityId;

	private $defaultSettings;

	/** @var ThemeSettingsPersistence $themeSettingsPersistence */
	private $themeSettingsPersistence;

	function __construct( $cityId = null ) {
		global $wgCityId, $wgOasisThemes;

		if ( empty( $cityId ) ) {
			$cityId = $wgCityId;
		}

		$this->cityId = $cityId;

		$wgSitename = WikiFactory::getVarValueByName( 'wgSitename', $cityId );
		$wgAdminSkin = WikiFactory::getVarValueByName( 'wgAdminSkin', $cityId );

		$adminSkin = explode( '-', $wgAdminSkin );
		$themeName = 'oasis';

		if ( count( $adminSkin ) == 2 ) {
			$transition = [
				'sky' => 'oasis',
				'sapphire' => 'oasis',
				'spring' => 'jade',
				'forest' => 'jade',
				'obsession' => 'carbon',
				'moonlight' => 'bluesteel',
				'beach' => 'creamsicle',
			];

			if ( isset( $transition[$adminSkin[1]] ) ) {
				$themeName = $transition[$adminSkin[1]];
			}
		}

		// colors
		$this->defaultSettings = $wgOasisThemes[$themeName];
		$this->defaultSettings['theme'] = $themeName;
		$this->defaultSettings['color-body-middle'] = $this->defaultSettings['color-body'];

		// wordmark
		$this->defaultSettings['wordmark-text'] = $wgSitename;
		$this->defaultSettings['wordmark-color'] = $this->defaultSettings['color-links'];
		$this->defaultSettings['wordmark-font'] = '';
		$this->defaultSettings['wordmark-font-size'] = 'medium';
		$this->defaultSettings['wordmark-image-url'] = '';
		$this->defaultSettings['wordmark-image-name'] = '';
		$this->defaultSettings['wordmark-type'] = "text";

		// background
		$this->defaultSettings['background-image'] = '';
		$this->defaultSettings['background-image-height'] = null;
		$this->defaultSettings['background-image-name'] = '';
		$this->defaultSettings['background-image-width'] = null;
		$this->defaultSettings['background-tiled'] = false;
		$this->defaultSettings['background-fixed'] = false;
		$this->defaultSettings['background-dynamic'] = true;

		//community header background
		$this->defaultSettings['community-header-background-image'] = '';
		$this->defaultSettings['community-header-background-image-name'] = '';

		//favicon
		$this->defaultSettings['favicon-image-name'] = '';

		$this->themeSettingsPersistence = new ThemeSettingsPersistence( $this );
	}

	/**
	 * @return int
	 */
	public function getCityId() {
		return $this->cityId;
	}

	public function getSettings() {
		$wikiFactorySettings = $this->themeSettingsPersistence->getSettings();

		if ( empty( $wikiFactorySettings ) ) {
			return $this->defaultSettings;
		}

		$settings = array_merge( $this->defaultSettings, $wikiFactorySettings );

		// if user didn't define community header background color, but defined buttons color, we use buttons color
		// as default for community header background
		if (
			!isset( $wikiFactorySettings["color-community-header"] ) &&
			isset( $wikiFactorySettings["color-buttons"]
			)
		) {
			$settings["color-community-header"] = $settings["color-buttons"];
		}

		// if any of the user set colors are invalid, use default
		foreach ( ThemeDesignerHelper::getColorVars() as $colorKey => $defaultValue ) {
			if ( !ThemeDesignerHelper::isValidColor( $settings[$colorKey] ) ) {
				$settings = $this->defaultSettings;
				break;
			}
		}

		return $settings;
	}

	public function getFreshURL( $name, $definedName ) {
		$title = Title::newFromText( $definedName, NS_FILE );

		if ( $definedName != $name ) {
			$file = OldLocalFile::newFromArchiveName( $title, RepoGroup::singleton()->getLocalRepo(), $name );
		} else {
			$file = new LocalFile( $title, RepoGroup::singleton()->getLocalRepo() );
		}

		return wfReplaceImageServer( $file->getUrl() );
	}

	public function getHistory() {
		$wikiFactoryHistory = WikiFactory::getVarValueByName(
			self::WikiFactoryHistory,
			$this->cityId
		);

		if ( !empty( $wikiFactoryHistory ) ) {
			$history = $wikiFactoryHistory;
			foreach ( $history as &$entry ) {
				$entry['settings'] = array_merge( $this->defaultSettings, $entry['settings'] );
			}
		} else {
			$history = [];
		}

		foreach ( $history as $key => $val ) {
			if ( !empty( $val['settings']['background-image-name'] ) ) {
				$val['settings']['background-image'] = $this->getFreshURL(
					$val['settings']['background-image-name'],
					ThemeSettings::BackgroundImageName
				);
			}

			if ( !empty( $val['settings']['community-header-background-image-name'] ) ) {
				$val['settings']['community-header-background-image'] = $this->getFreshURL(
					$val['settings']['community-header-background-image-name'],
					ThemeSettings::CommunityHeaderBackgroundImageName
				);
			}
		}

		return $history;
	}

	public function saveSettings( $settings ) {
		// SUS-2942: unset unknown properties
		foreach ( $settings as $key => $value ) {
			if ( !array_key_exists( $key, $this->defaultSettings ) ) {
				unset( $settings[$key] );
			}
		}

		if ( !empty( $settings['wordmark-font'] ) ) {
			$settings['wordmark-font'] = $this->escapeInput( $settings['wordmark-font'] );
		}

		if ( !empty( $settings['wordmark-font-size'] ) ) {
			$settings['wordmark-font-size'] = $this->escapeInput( $settings['wordmark-font-size'] );
		}

		if ( !empty( $settings['wordmark-type'] ) ) {
			$settings['wordmark-type'] = $this->escapeInput( $settings['wordmark-type'] );
		}

		// SUS-2942: validate user-provided opacity value
		if ( !empty( $settings['page-opacity'] ) ) {
			$settings['page-opacity'] = max( intval( $settings['page-opacity'] ), 50 );
		}

		// Verify wordmark length ( CONN-116 )
		if ( !empty( $settings['wordmark-text'] ) ) {
			$settings['wordmark-text'] = $this->escapeInput( trim( $settings['wordmark-text'] ) );
		}

		if ( empty( $settings['wordmark-text'] ) ) {
			// Do not save wordmark if its empty.
			unset( $settings['wordmark-text'] );
		} elseif ( mb_strlen( $settings['wordmark-text'] ) > 50 ) {
			$settings['wordmark-text'] = mb_substr( $settings['wordmark-text'], 0, 50 );
		}

		// #140758 - Jakub
		// validation
		// default color values
		foreach ( ThemeDesignerHelper::getColorVars() as $sColorVar => $sDefaultValue ) {
			if ( !isset( $settings[$sColorVar] ) || !ThemeDesignerHelper::isValidColor( $settings[$sColorVar] ) ) {
				$settings[$sColorVar] = $sDefaultValue;
			}
		}

		$this->themeSettingsPersistence->saveSettings( $settings );
	}

	/**
	 * Return escaped version of provided text, while avoiding double escaping it
	 * @param string $text
	 * @return string
	 */
	private function escapeInput( string $text ) {
		return htmlspecialchars( Sanitizer::decodeCharReferences( $text ), ENT_QUOTES );
	}

	/**
	 * Get wordmark full, up-to-date URL
	 *
	 * This method returns URL based on "wordmark-image-url" and performs URL rewrite
	 * for migrated wikis with short Swift bucket name
	 *
	 * @see  $wgUploadPath - "http://images.wikia.com/24_/es/images"
	 *
	 * @author macbre
	 * @return string wordmark URL or empty string if not found
	 */
	public function getWordmarkUrl() {
		$wgUploadPath = WikiFactory::getVarValueByName(
			'wgUploadPath',
			$this->cityId
		);

		$wordmarkUrl = $this->getSettings()['wordmark-image-url'];

		if ( !VignetteRequest::isVignetteUrl( $wordmarkUrl ) ) {
			$wordmarkPath = explode( '/images/', $wordmarkUrl )[0];

			if ( !empty( $wordmarkPath ) ) {
				$wordmarkUrl = str_replace(
					$wordmarkPath . '/images',
					$wgUploadPath,
					$wordmarkUrl
				);
			}

			$wordmarkUrl = wfReplaceImageServer( $wordmarkUrl, SassUtil::getCacheBuster() );
		}

		return $wordmarkUrl;
	}

	/**
	 * Get wiki background full, up-to-date URL
	 *
	 * This method returns URL based on "background-image" and performs URL rewrite
	 * for migrated wikis with short Swift bucket name
	 *
	 * @see  $wgUploadPath - "http://images.wikia.com/24_/es/images"
	 *
	 * @author macbre
	 * @return string background URL or empty string if not found
	 */
	public function getBackgroundUrl(): string {
		return $this->getVignetteUrl( $this->getSettings()['background-image'] );
	}

	/**
	 * Get community header background full, up-to-date URL
	 *
	 * This method returns URL based on "community-header-background-image"
	 *
	 * @return string background URL or empty string if not found
	 */
	public function getCommunityHeaderBackgroundUrl(): string {
		$thumbnailUrl = '';
		$originalUrl = $this->getSettings()['community-header-background-image'];

		try {
			if ( VignetteRequest::isVignetteUrl( $originalUrl ) ) {
				$thumbnailUrl = VignetteRequest::fromUrl( $originalUrl )
					->zoomCrop()
					->width( self::COMMUNITY_HEADER_BACKGROUND_WIDTH )
					->height( self::COMMUNITY_HEADER_BACKGROUND_HEIGHT )
					->url();
			}
		} catch ( InvalidArgumentException $e ) {
			\Wikia\Logger\WikiaLogger::instance()
				->warning("Wrong url to community-header-background-image", [ 'originalUrl' => $originalUrl ] );
		}

		return $thumbnailUrl;
	}

	/**
	 * @param string $backgroundUrl
	 * @return string
	 */
	private function getVignetteUrl( string $backgroundUrl ): string {
		$wgUploadPath = WikiFactory::getVarValueByName(
			'wgUploadPath',
			$this->cityId
		);

		if ( !VignetteRequest::isVignetteUrl( $backgroundUrl ) ) {
			if ( empty( $backgroundUrl ) ) {
				return $backgroundUrl;
			}

			$backgroundPath = explode( '/images/', $backgroundUrl )[0];

			if ( !empty( $wordmarkPath ) ) {
				$backgroundUrl = str_replace(
					$backgroundPath . '/images',
					$wgUploadPath,
					$backgroundUrl
				);
			}

			return wfReplaceImageServer( $backgroundUrl, SassUtil::getCacheBuster() );
		}

		return $backgroundUrl;
	}
}
