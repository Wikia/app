<?php

class WdsLineImage {
	use WdsImageTrait;
	use WdsTitleTrait;
	use WdsTrackingLabelTrait;

	const TYPE = 'line-image';

	private $subtitle;

	public function setSubtitle( $value ) {
		$this->subtitle = ( new WdsText( $value ) )->get();

		return $this;
	}

	public function setTranslatableSubtitle( $key ) {
		$this->subtitle = ( new WdsTranslatableText( $key ) )->get();

		return $this;
	}

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
