<?php

trait WdsImageTrait {
	private $image;
	private $imageData;

	public function setSvgImageData( $key ) {
		$this->image = $key;
		$this->imageData = ( new WdsSvg( $key ) )->get();

		return $this;
	}

	public function setExternalImageData( $url ) {
		$this->imageData = ( new WdsExternalImage( $url ) )->get();

		return $this;
	}
}
