<?php

trait WdsImageTrait {
	public $image;
	public $imageData;

	public function setSvgImageData( $key ) {
		$this->image = $key;
		$this->imageData = new WdsSvg( $key );

		return $this;
	}

	public function setExternalImageData( $url ) {
		$this->imageData = new WdsExternalImage( $url );

		return $this;
	}
}
