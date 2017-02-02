<?php

class WdsNotificationsModule {
	public $type = 'notifications';
	public $url;

	/**
	 * @param string $url
	 * @return WdsNotificationsModule
	 */
	public function setUrl( string $url ) {
		$this->url = $url;

		return $this;
	}
}
