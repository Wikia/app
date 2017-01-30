<?php

/**
 * Created by PhpStorm.
 * User: ryba
 * Date: 30/01/2017
 * Time: 09:36
 */
trait WdsSubtitleTrait {
	private $subtitle;

	public function setSubtitle( $value ) {
		$this->subtitle = ( new WdsText( $value ) )->get();

		return $this;
	}

	public function setTranslatableSubtitle( $key ) {
		$this->subtitle = ( new WdsTranslatableText( $key ) )->get();

		return $this;
	}
}