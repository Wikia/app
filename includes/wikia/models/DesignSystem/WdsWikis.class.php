<?php

class WdsWikis {
	public $header;
	public $links = [];

	/**
	 * @param WdsLineTextTrackable $header
	 * @return WdsWikis
	 */
	public function setHeader( WdsLineTextTrackable $header ) {
		$this->header = $header;

		return $this;
	}

	/**
	 * @param array $links
	 * @return WdsWikis
	 */
	public function setLinks( array $links ) {
		$this->links = $links;

		return $this;
	}


}
