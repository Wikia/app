<?php
namespace CommunityHeader;

class Image {
	public function __construct( $url, $width, $height ) {
		$this->url = $url;
		$this->width = $width;
		$this->height = $height;
	}
}
