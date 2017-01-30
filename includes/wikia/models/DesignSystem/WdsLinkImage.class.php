<?php

class WdsLinkImage implements JsonSerializable {
	use WdsTitleTrait;
	use WdsLinkTrait;
	use WdsTrackingLabelTrait;
	use WdsImageTrait;

	const TYPE = 'link-image';

	// need to implement this method in order to return `image-data` as a key
	function jsonSerialize() {
		$result = [
			'type' => self::TYPE,
			'image-data' => $this->imageData,
			'title' => $this->title,
			'href' => $this->href,
			'tracking_label' => $this->tracking_label
		];

		if ( isset( $this->image ) ) {
			// 'image' is deprecated, use 'image-data' instead
			$result['image'] = $this->image;
		}

		return $result;
	}
}
