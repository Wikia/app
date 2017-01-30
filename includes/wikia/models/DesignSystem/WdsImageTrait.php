<?php

trait WdsImageTrait {
	public $image;

	public function setSvgImageData( $key ) {
		$this->image = $key;
		$this->{'image-data'} = new WdsSvg( $key );

		return $this;
	}

	public function setExternalImageData( $url ) {
		$this->image = null;
		$this->{'image-data'} = new WdsExternalImage( $url );

		return $this;
	}
}
