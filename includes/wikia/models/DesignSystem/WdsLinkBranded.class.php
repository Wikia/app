<?php

class WdsLinkBranded {
	use WdsTitleTrait;
	use WdsLinkTrait;
	use WdsTrackingLabelTrait;

	public $type = 'link-branded';
	public $brand;

	public function setBrand( $brand ) {
		$this->brand = $brand;

		return $this;
	}
}
