<?php
namespace CommunityHeader;

class Image {
	public function __construct( string $url, int $width, int $height ) {
		$this->url = $url;
		$this->width = $width;
		$this->height = $height;
	}
}
