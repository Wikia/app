<?php

class WdsLinkImage {
	use WdsTitleTrait;
	use WdsLinkTrait;
	use WdsTrackingLabelTrait;

	const TYPE = 'link-image';

	private $image;
	private $imageData;

	public function setSvgImageData( $key ) {
		$this->image = $key;
		$this->imageData = ( new WdsSvg( $key ) )->get();

		return $this;
	}

	public function setExternalImageData( $url ) {
		$this->imageData = ( new WdsExternalImage( $url ) )->get();

		return $this;
	}

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
