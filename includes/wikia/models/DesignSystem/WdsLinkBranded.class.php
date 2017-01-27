<?php

class WdsLinkBranded {
	use WdsTitleTrait;
	use WdsLinkTrait;

	const TYPE = 'link-branded';

	private $brand;

	public function setBrand( $brand ) {
		$this->brand = $brand;

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