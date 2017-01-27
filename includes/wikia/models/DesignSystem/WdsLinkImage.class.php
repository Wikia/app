<?php

class WdsLinkImage {
	use WdsTitleTrait;
	use WdsLinkTrait;
	use WdsTrackingLabelTrait;
	use WdsImageTrait;

	const TYPE = 'link-image';

	public function get() {
		$result = [
			'type' => self::TYPE,
			'image-data' => $this->imageData,
			'title' => $this->title,
			'href' => $this->href,
			'tracking_label' => $this->trackingLabel
		];

		if ( isset( $this->image ) ) {
			// 'image' is deprecated, use 'image-data' instead
			$result['image'] = $this->image;
		}

		return $result;
	}
}
