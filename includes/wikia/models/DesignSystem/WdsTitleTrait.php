<?php

trait WdsTitleTrait {
	private $title;

	public function setTitle( $value ) {
		$this->title = ( new TextObject( $value ) )->get();

		return $this;
	}

	public function setTranslatableTitle( $key ) {
		$this->title = ( new TranslatableTextObject( $key ) )->get();

		return $this;
	}
}