<?php

class WdsExternalImage {
	const TYPE = 'image-external';

	private $url;

	public function __construct( $url ) {
		$this->url = $url;
	}

	public function get() {
		return [
			'type' => self::TYPE,
			'url' => $this->url
		];
	}
}