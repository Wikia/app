<?php

namespace Wikia\CommunityHeader;

class Image {
	public $height;
	public $url;
	public $width;

	public function __construct( string $url, int $width, int $height ) {
		$this->url = $url;
		$this->width = $width;
		$this->height = $height;
	}
}
