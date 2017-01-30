<?php

trait WdsLinkTrait {
	public $href;

	public function setHref( $href ) {
		$this->href = $href;

		return $this;
	}
}
