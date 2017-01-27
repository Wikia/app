<?php

trait WdsTrackingLabelTrait {
	private $trackingLabel;

	public function setTrackingLabel( $label ) {
		$this->trackingLabel = $label;

		return $this;
	}
}