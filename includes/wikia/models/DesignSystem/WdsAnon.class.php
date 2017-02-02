<?php

class WdsAnon {
	public $header;
	public $links = [];

	/**
	 * @param WdsLineImageWithSubtitle $header
	 * @return WdsAnon
	 */
	public function setHeader( WdsLineImageWithSubtitle $header ) {
		$this->header = $header;

		return $this;
	}

	/**
	 * @param array $links
	 * @return WdsAnon
	 */
	public function setLinks( array $links ) {
		$this->links = $links;

		return $this;
	}


}
