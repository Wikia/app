<?php

class WdsExternalImage {
	public $type = 'image-external';
	public $url;

	public function __construct( $url ) {
		$this->url = $url;
	}
}
