<?php

class LinkTextObject {
	const TYPE = 'link-text';
	private $title;
	private $href;
	private $trackingLabel;

	public function __construct() {
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

	public function setTrackingLabel( $trackingLabel ) {
		$this->trackingLabel = $trackingLabel;

		return $this;
	}

	public function get() {
		return [
			'type' => self::TYPE,
			'title' => $this->title,
			'href' => $this->href,
			'tracking_label' => $this->trackingLabel
		];
	}
}