<?php

namespace Wikia\CommunityHeader;

use DesignSystemCommunityHeaderModel;
use File;
use ThemeSettings;
use Title;

class Wordmark {
	const WORDMARK_TYPE_GRAPHIC = 'graphic';

	private $isValid;

	public $href;
	public $label;
	public $image;
	public $trackingLabel;

	public function __construct( DesignSystemCommunityHeaderModel $model ) {
		$wordmarkData = $model->getWordmarkData();

		$this->isValid = false;

		if ( !empty( $wordmarkData['image-data']['url'] ) ) {
			$this->href = $wordmarkData['href'];
			$this->label = new Label( $wordmarkData['title']['value'] );
			$this->trackingLabel = $wordmarkData['tracking_label'];

			$wordmarkURL = $wordmarkData['image-data']['url'];

			$imageTitle = Title::newFromText( ThemeSettings::WordmarkImageName, NS_IMAGE );
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
