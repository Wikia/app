<?php
namespace CommunityHeader;

use \ThemeSettings;
use \Title;
use \File;

class Wordmark {
	const WORDMARK_TYPE_GRAPHIC = 'graphic';

	public function __construct() {
		$themeSettings = new ThemeSettings();
		$settings = $themeSettings->getSettings();

		$this->isValid = false;

		if ( $settings['wordmark-type'] === self::WORDMARK_TYPE_GRAPHIC ) {
			$this->mainPageURL = Title::newMainPage()->getLocalURL();
			$this->wordmarkText = $settings['wordmark-text'];
			$this->wordmarkURL = $themeSettings->getWordmarkUrl();
			$this->wordmarkSize = [];

			$imageTitle = Title::newFromText( $themeSettings::WordmarkImageName, NS_IMAGE );
			if ( $imageTitle instanceof Title ) {
				$file = wfFindFile( $imageTitle );
				if ( $file instanceof File && $file->width > 0 && $file->height > 0 ) {
					$this->wordmarkSize['width'] = $file->width;
					$this->wordmarkSize['height'] = $file->height;
					$this->isValid = true;
				}
			}
		}
	}

	public function getData() {
		if ( !$this->isValid ) {
			return [];
		}

		return [
			'href' => $this->mainPageURL,
			'label' => [
				'type' => 'text',
				'value' => $this->wordmarkText,
			],
			'image' => [
				'url' => $this->wordmarkURL,
				'width' => $this->wordmarkSize['width'],
				'height' => $this->wordmarkSize['height'],
			],
		];
	}


}
