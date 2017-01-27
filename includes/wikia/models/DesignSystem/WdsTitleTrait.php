<?php

trait WdsTitleTrait {
	private $title;

	public function setTitle( $value ) {
		$this->title = ( new WdsText( $value ) )->get();

		return $this;
	}

	public function setTranslatableTitle( $key ) {
		$this->title = ( new WdsTranslatableText( $key ) )->get();

		return $this;
	}
}
