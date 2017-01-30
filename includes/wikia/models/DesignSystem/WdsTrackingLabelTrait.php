<?php

trait WdsTrackingLabelTrait {
	public $tracking_label;

	public function setTrackingLabel( $label ) {
		$this->tracking_label = $label;

		return $this;
	}
}
