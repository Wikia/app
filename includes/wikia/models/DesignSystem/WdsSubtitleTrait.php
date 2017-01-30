<?php

trait WdsSubtitleTrait {
	public $subtitle;

	public function setSubtitle( $value ) {
		$this->subtitle = new WdsText( $value );

		return $this;
	}

	public function setTranslatableSubtitle( $key ) {
		$this->subtitle = new WdsTranslatableText( $key );

		return $this;
	}
}
