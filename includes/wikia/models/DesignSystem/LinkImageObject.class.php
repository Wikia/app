<?php

class LinkImageObject {
	const TYPE = 'link-image';
	private $image;
	private $imageData;
	private $title;
	private $href;
	private $trackingLabel;

	public function __construct() {
	}

	public function setImageData( $key ) {
		$this->image = $key;
		$this->imageData = ( new WdsSvgObject( $key ) )->get();

		return $this;
	}

	public function setTitle( $value ) {
		$this->title = ( new TextObject( $value ) )->get();

		return $this;
	}

	public function setTranslatableTitle( $key ) {
		$this->title = ( new TranslatableTextObject( $key ) )->get();

		return $this;
	}

	public function setHref( $href ) {
		$this->href = $href;

		return $this;
	}

	public function setTrackingLabel( $label ) {
		$this->trackingLabel = $label;

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