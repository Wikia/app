<?php

class WdsUser {
	public $header;
	public $links;

	/**
	 * @param mixed $header
	 * @return WdsUser
	 */
	public function setHeader( $header ) {
		$this->header = $header;

		return $this;
	}

	/**
	 * @param array $links
	 * @return WdsUser
	 */
	public function setLinks( array $links ) {
		$this->links = $links;

		return $this;
	}
}
