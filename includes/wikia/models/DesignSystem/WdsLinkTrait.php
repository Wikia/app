<?php

trait WdsLinkTrait {
	private $href;

	public function setHref( $href ) {
		$this->href = $href;

		return $this;
	}
}
