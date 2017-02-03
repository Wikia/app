<?php

class WdsAvatar {
	use WdsTrackingLabelTrait;

	public $type = 'avatar';
	public $username;
	public $url;

	/**
	 * @param WdsText $username
	 * @return WdsAvatar
	 */
	public function setUsername( WdsText $username ) {
		$this->username = $username;

		return $this;
	}

	/**
	 * @param string $url
	 * @return WdsAvatar
	 */
	public function setUrl( string $url ) {
		$this->url = $url;

		return $this;
	}
}
