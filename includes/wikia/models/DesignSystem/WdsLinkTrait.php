<?php

trait WdsLinkTrait {
	private $href;
	private $trackingLabel;

	public function setHref( $href ) {
		$this->href = $href;

		return $this;
	}

	public function setTrackingLabel( $label ) {
		$this->trackingLabel = $label;

		return $this;
	}
}