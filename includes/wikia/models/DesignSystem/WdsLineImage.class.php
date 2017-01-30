<?php

class WdsLineImage {
	use WdsImageTrait;
	use WdsTitleTrait;
	use WdsTrackingLabelTrait;
	use WdsSubtitleTrait;

	const TYPE = 'line-image';

	public function get() {
		$result = [
			'type' => self::TYPE,
			'image-data' => $this->imageData,
			'title' => $this->title,
			'tracking_label' => $this->trackingLabel
		];

		if ( isset( $this->image ) ) {
			$result['image'] = $this->image;
		}

		if ( isset( $this->subtitle ) ) {
			$result['subtitle'] = $this->subtitle;
		}

		return $result;
	}
}
