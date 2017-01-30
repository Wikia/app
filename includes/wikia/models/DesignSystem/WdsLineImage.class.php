<?php

class WdsLineImage implements JsonSerializable {
	use WdsImageTrait;
	use WdsTitleTrait;
	use WdsTrackingLabelTrait;
	use WdsSubtitleTrait;

	public $type = 'line-image';

	// need to implement this method in order to return `image-data` as a key
	function jsonSerialize() {
		$result = [
			'type' => $this->type,
			'image-data' => $this->imageData,
			'title' => $this->title,
			'tracking_label' => $this->tracking_label
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
