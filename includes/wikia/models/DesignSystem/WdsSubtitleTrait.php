<?php

/**
 * Created by PhpStorm.
 * User: ryba
 * Date: 30/01/2017
 * Time: 09:36
 */
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