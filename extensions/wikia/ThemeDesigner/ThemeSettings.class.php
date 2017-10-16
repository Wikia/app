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
	}

	public function getSettings() {
		$settings = $this->defaultSettings;
		$wikiFactorySettings = WikiFactory::getVarValueByName(
			self::WikiFactorySettings,
			$this->cityId
		);

		if ( !empty( $wikiFactorySettings ) ) {
			$settings = array_merge( $settings, $wikiFactorySettings );

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

		}
		// special check for color-body-middle
		if ( !isset( $settings['color-body-middle'] ) || !ThemeDesignerHelper::isValidColor( $settings["color-body-middle"] ) ) {
			$settings["color-body-middle"] = $settings["color-body"];
		}

		// add variables that might not be saved already in WF
		if ( !isset( $settings['background-fixed'] ) ) {
			$settings['background-fixed'] = false;
		}
		if ( !isset( $settings['page-opacity'] ) ) {
			$settings['page-opacity'] = 100;
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

	private function saveImage(
		array &$settings,
		string $name,
		string $title,
		array $previewThumbnailDimensions = [],
		bool $setDimensions = false,
		callable $callback = null
	) {
		// SUS-2942: No new file for upload, stop here
		if ( !isset( $settings["{$name}-name"] ) || strpos( $settings["{$name}-name"], 'Temp_file_' ) !== 0 ) {
			return null;
		}

		$fileRepo = RepoGroup::singleton()->getLocalRepo();
		$imageTitle = Title::makeTitle( NS_FILE, $title );

		$file = new LocalFile( $imageTitle, $fileRepo );

		$temp_file = new LocalFile( Title::newFromText( $settings["{$name}-name"], NS_FILE ), $fileRepo );
		$file->upload( $temp_file->getPath(), '', '' );
		$temp_file->delete( '' );

		// For legacy reasons wordmark-image has other convention than the rest
		if ( $name === 'wordmark-image' ) {
			$settings['wordmark-image-url'] = $file->getURL();
		} else {
			$settings["{$name}"] = $file->getURL();
		}
		$settings["{$name}-name"] = $file->getName();

		if ( $setDimensions ) {
			$settings["${name}-height"] = $file->getHeight();
			$settings["${name}-width"] = $file->getWidth();
		}

		if ( !empty( $previewThumbnailDimensions ) ) {
			$imageServing = new ImageServing(
				null,
				$previewThumbnailDimensions['width'],
				[
					'w' => $previewThumbnailDimensions['width'],
					'h' => $previewThumbnailDimensions['height']
				]
			);
			$settings["user-{$name}"] = $file->getURL();
			$settings["user-{$name}-thumb"] = wfReplaceImageServer(
				$file->getThumbUrl(
					$imageServing->getCut(
						$file->getWidth(),
						$file->getHeight(),
						'origin'
					) . '-' . $file->getName()
				)
			);
		}

		if ( is_callable( $callback ) ) {
			$callback();
		}

		// SUS-3044 | push an upload to image review queue
		Hooks::run( 'ThemeDesignerSaveImage', [ $file->getTitle() ] );

		$file->repo->forceMaster();

		/* @var OldLocalFile[] $history */
		$history = $file->getHistory( 1 );

		if ( count( $history ) == 1 ) {
			return [ 'url' => $history[0]->getURL(), 'name' => $history[0]->getArchiveName() ];
		}

		return null;
	}

	public function saveSettings( $settings ) {
		global $wgUser;

		// SUS-2942: unset unknown properties
		foreach ( $settings as $key => $value ) {
			if ( !isset( $this->defaultSettings[$key] ) ) {
				unset( $settings[$key] );
			}
		}

		if ( !empty( $settings['wordmark-font'] ) ) {
			$settings['wordmark-font'] = htmlspecialchars( $settings['wordmark-font'], ENT_QUOTES );
		}

		if ( !empty( $settings['wordmark-font-size'] ) ) {
			$settings['wordmark-font-size'] = htmlspecialchars( $settings['wordmark-font-size'], ENT_QUOTES );
		}

		if ( !empty( $settings['wordmark-type'] ) ) {
			$settings['wordmark-type'] = htmlspecialchars( $settings['wordmark-type'], ENT_QUOTES );
		}

		// SUS-2942: validate user-provided opacity value
		if ( !empty( $settings['page-opacity'] ) ) {
			$settings['page-opacity'] = max( intval( $settings['page-opacity'] ), 50 );
		}

		// Verify wordmark length ( CONN-116 )
		if ( !empty( $settings['wordmark-text'] ) ) {
			$settings['wordmark-text'] = htmlspecialchars( trim( $settings['wordmark-text'] ), ENT_QUOTES );
		}

		if ( empty( $settings['wordmark-text'] ) ) {
			// Do not save wordmark if its empty.
			unset( $settings['wordmark-text'] );
		} else {
			if ( mb_strlen( $settings['wordmark-text'] ) > 50 ) {
				$settings['wordmark-text'] = mb_substr( $settings['wordmark-text'], 0, 50 );
			}
		}

		$oldBackgroundFile = $this->saveImage(
			$settings,
			'background-image',
			self::BackgroundImageName,
			[
				'width' => 120,
				'height' => 65
			],
			true
		);

		$oldCommunityHeaderFile = $this->saveImage(
			$settings,
			'community-header-background-image',
			self::CommunityHeaderBackgroundImageName,
			[
				'width' => 120,
				'height' => 33
			]
		);

		$oldWordmarkFile = $this->saveImage(
			$settings,
			'wordmark-image',
			self::WordmarkImageName
		);

		$oldFaviconFile = $this->saveImage(
			$settings,
			'favicon-image',
			self::FaviconImageName,
			[],
			false,
			function () {
				Wikia::invalidateFavicon();
			}
		);

		$reason = wfMessage( 'themedesigner-reason', $wgUser->getName() )->escaped();

		// update history
		$wikiFactoryHistory = WikiFactory::getVarValueByName(
			self::WikiFactoryHistory,
			$this->cityId
		);

		if ( !empty( $wikiFactoryHistory ) ) {
			$history = $wikiFactoryHistory;
			$lastItem = end( $history );
			$revisionId = intval( $lastItem['revision'] ) + 1;
		} else {
			$history = [];
			$revisionId = 1;
		}

		// #140758 - Jakub
		// validation
		// default color values
		foreach ( ThemeDesignerHelper::getColorVars() as $sColorVar => $sDefaultValue ) {
			if ( !isset( $settings[$sColorVar] ) || !ThemeDesignerHelper::isValidColor( $settings[$sColorVar] ) ) {
				$settings[$sColorVar] = $sDefaultValue;
			}
		}

		// SUS-2942: get not explicitly set values from old settings
		$oldSettings = $this->getSettings();
		$settings = array_merge( $oldSettings, $settings );

		// update WF variable with current theme settings
		WikiFactory::setVarByName( self::WikiFactorySettings, $this->cityId, $settings, $reason );

		// add entry
		$history[] = [
			'settings' => $settings,
			'author' => $wgUser->getName(),
			'timestamp' => wfTimestampNow(),
			'revision' => $revisionId,
		];

		// limit history size to last 10 changes
		$history = array_slice( $history, -self::HistoryItemsLimit );

		if ( count( $history ) > 1 ) {
			for ( $i = 0; $i < count( $history ) - 1; $i++ ) {
				if ( isset( $oldFaviconFile ) && isset( $history[$i]['settings']['favicon-image-name'] ) ) {
					if ( $history[$i]['settings']['favicon-image-name'] == self::FaviconImageName ) {
						$history[$i]['settings']['favicon-image-name'] = $oldFaviconFile['name'];
						$history[$i]['settings']['favicon-image-url'] = $oldFaviconFile['url'];
					}
				}
				if ( isset( $oldWordmarkFile ) && isset( $history[$i]['settings']['wordmark-image-name'] ) ) {
					if ( $history[$i]['settings']['wordmark-image-name'] == self::WordmarkImageName ) {
						$history[$i]['settings']['wordmark-image-name'] = $oldWordmarkFile['name'];
						$history[$i]['settings']['wordmark-image-url'] = $oldWordmarkFile['url'];
					}
				}
				if ( isset( $oldBackgroundFile ) && isset( $history[$i]['settings']['background-image-name'] ) ) {
					if ( $history[$i]['settings']['background-image-name'] == self::BackgroundImageName ) {
						$history[$i]['settings']['background-image-name'] = $oldBackgroundFile['name'];
					}
				}
				if ( isset( $oldCommunityHeaderFile ) && isset( $history[$i]['settings']['community-header-background-image-name'] ) ) {
					if ( $history[$i]['settings']['community-header-background-image-name'] == self::CommunityHeaderBackgroundImageName ) {
						$history[$i]['settings']['community-header-background-image-name'] = $oldCommunityHeaderFile['name'];
					}
				}
			}
		}

		WikiFactory::setVarByName( self::WikiFactoryHistory, $this->cityId, $history, $reason );
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
