<?php

class WdsCreateWiki {
	public $header;

	/**
	 * @param WdsLinkText $header
	 * @return WdsCreateWiki
	 */
	public function setHeader( WdsLinkText $header ) {
		$this->header = $header;

		return $this;
	}
}
