<?php

class WdsLinkImage {
	use WdsTitleTrait;
	use WdsLinkTrait;

	const TYPE = 'link-image';

	private $image;
	private $imageData;

	public function setImageData( $key ) {
		$this->image = $key;
		$this->imageData = ( new WdsSvg( $key ) )->get();

		return $this;
	}

	public function get() {
		return [
			'type' => self::TYPE,
			// 'image' is deprecated, use 'image-data' instead
			'image' => $this->image,
			'image-data' => $this->imageData,
			'title' => $this->title,
			'href' => $this->href,
			'tracking_label' => $this->trackingLabel
		];
	}
}