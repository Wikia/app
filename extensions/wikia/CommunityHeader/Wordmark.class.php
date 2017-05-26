<?php
namespace CommunityHeader;

use \ThemeSettings;
use \Title;
use \File;

class Wordmark {
	const WORDMARK_TYPE_GRAPHIC = 'graphic';

	private $isValid;

	public function __construct() {
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->isValid = false;

		if ( $settings['wordmark-type'] === self::WORDMARK_TYPE_GRAPHIC ) {
			$this->href = Title::newMainPage()->getLocalURL();
			$this->label = new Label( $settings['wordmark-text'] );
			$wordmarkURL = $themeSettings->getWordmarkUrl();

			$imageTitle = Title::newFromText( $themeSettings::WordmarkImageName, NS_IMAGE );
			if ( $imageTitle instanceof Title ) {
				$file = wfFindFile( $imageTitle );
				if ( $file instanceof File && $file->width > 0 && $file->height > 0 ) {
					$this->image = new Image( $wordmarkURL, $file->width, $file->height );
					$this->isValid = true;
				}
			}
		}
	}

	/**
	 * @return bool
	 */
	public function hasWordmark(): bool {
		return $this->isValid;
	}
}
