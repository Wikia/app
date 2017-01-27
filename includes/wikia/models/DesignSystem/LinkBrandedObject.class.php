<?php

class LinkBrandedObject {
	const TYPE = 'link-branded';
	private $brand;
	private $title;
	private $href;
	private $trackingLabel;

	public function __construct() {
	}

	public function setBrand( $brand ) {
		$this->brand = $brand;

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
			'brand' => $this->brand,
			'title' => $this->title,
			'href' => $this->href,
			'tracking_label' => $this->trackingLabel,
		];
	}
}