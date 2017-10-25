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

		if ( !empty( $wordmarkData ) ) {
			$this->href = $wordmarkData['href'];
			$this->label = new Label( $wordmarkData['title']['value'] );
			$this->trackingLabel = $wordmarkData['tracking_label'];
			$this->image = new Image(
				$wordmarkData['image-data']['url'],
				$wordmarkData['image-data']['width'],
				$wordmarkData['image-data']['height']
			);
			$this->isValid = true;
		}
	}

	/**
	 * @return bool
	 */
	public function hasWordmark(): bool {
		return $this->isValid;
	}
}
