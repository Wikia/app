<?php

class WdsNotifications {
	public $header;
	public $module;

	/**
	 * @param WdsLineImage $header
	 * @return WdsNotifications
	 */
	public function setHeader( WdsLineImage $header ) {
		$this->header = $header;

		return $this;
	}

	/**
	 * @param mixed $module
	 * @return WdsNotifications
	 */
	public function setModule( $module ) {
		$this->module = $module;

		return $this;
	}
}
