<?php

class ThemeSettingsPersistence {
	/** @var ThemeSettings $themeSettings */
	private $themeSettings;
	/** @var int $cityId */
	private $cityId;

	public function __construct( ThemeSettings $themeSettings ) {
		$this->themeSettings = $themeSettings;
		$this->cityId = $themeSettings->getCityId();
	}

	public function getSettings() {
		return WikiFactory::getVarValueByName(
			ThemeSettings::WikiFactorySettings,
			$this->cityId
		);
	}

	public function saveSettings( $settings ) {
		global $wgUser;
		
		$oldBackgroundFile = $this->saveImage(
			$settings,
			'background-image',
			ThemeSettings::BackgroundImageName,
			[
				'width' => 120,
				'height' => 65
			],
			true
		);

		$oldCommunityHeaderFile = $this->saveImage(
			$settings,
			'community-header-background-image',
			ThemeSettings::CommunityHeaderBackgroundImageName,
			[
				'width' => 120,
				'height' => 33
			]
		);

		$oldWordmarkFile = $this->saveImage(
			$settings,
			'wordmark-image',
			ThemeSettings::WordmarkImageName
		);

		$oldFaviconFile = $this->saveImage(
			$settings,
			'favicon-image',
			ThemeSettings::FaviconImageName,
			[],
			false,
			function () {
				Wikia::invalidateFavicon();
			}
		);

		$reason = wfMessage( 'themedesigner-reason', $wgUser->getName() )->escaped();

		// update history
		$wikiFactoryHistory = WikiFactory::getVarValueByName(
			ThemeSettings::WikiFactoryHistory,
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

		// SUS-2942: get not explicitly set values from old settings
		$oldSettings = $this->themeSettings->getSettings();
		$settings = array_merge( $oldSettings, $settings );
		// update WF variable with current theme settings
		WikiFactory::setVarByName( ThemeSettings::WikiFactorySettings, $this->cityId, $settings, $reason );

		// add entry
		$history[] = [
			'settings' => $settings,
			'author' => $wgUser->getName(),
			'timestamp' => wfTimestampNow(),
			'revision' => $revisionId,
		];

		// limit history size to last 10 changes
		$history = array_slice( $history, -ThemeSettings::HistoryItemsLimit );

		if ( count( $history ) > 1 ) {
			for ( $i = 0; $i < count( $history ) - 1; $i++ ) {
				if ( isset( $oldFaviconFile ) && isset( $history[$i]['settings']['favicon-image-name'] ) ) {
					if ( $history[$i]['settings']['favicon-image-name'] == ThemeSettings::FaviconImageName ) {
						$history[$i]['settings']['favicon-image-name'] = $oldFaviconFile['name'];
						$history[$i]['settings']['favicon-image-url'] = $oldFaviconFile['url'];
					}
				}
				if ( isset( $oldWordmarkFile ) && isset( $history[$i]['settings']['wordmark-image-name'] ) ) {
					if ( $history[$i]['settings']['wordmark-image-name'] == ThemeSettings::WordmarkImageName ) {
						$history[$i]['settings']['wordmark-image-name'] = $oldWordmarkFile['name'];
						$history[$i]['settings']['wordmark-image-url'] = $oldWordmarkFile['url'];
					}
				}
				if ( isset( $oldBackgroundFile ) && isset( $history[$i]['settings']['background-image-name'] ) ) {
					if ( $history[$i]['settings']['background-image-name'] == ThemeSettings::BackgroundImageName ) {
						$history[$i]['settings']['background-image-name'] = $oldBackgroundFile['name'];
					}
				}
				if ( isset( $oldCommunityHeaderFile ) && isset( $history[$i]['settings']['community-header-background-image-name'] ) ) {
					if ( $history[$i]['settings']['community-header-background-image-name'] == ThemeSettings::CommunityHeaderBackgroundImageName ) {
						$history[$i]['settings']['community-header-background-image-name'] = $oldCommunityHeaderFile['name'];
					}
				}
			}
		}

		WikiFactory::setVarByName( ThemeSettings::WikiFactoryHistory, $this->cityId, $history, $reason );
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

		$file->repo->forceMaster();

		/* @var OldLocalFile[] $history */
		$history = $file->getHistory( 1 );

		if ( count( $history ) == 1 ) {
			return [ 'url' => $history[0]->getURL(), 'name' => $history[0]->getArchiveName() ];
		}

		return null;
	}
}
