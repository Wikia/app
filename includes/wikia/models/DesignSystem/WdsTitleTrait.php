<?php

trait WdsTitleTrait {
	public $title;

	public function setTitle( $value ) {
		$this->title = new WdsText( $value );

		return $this;
	}

	public function setTranslatableTitle( $key ) {
		$this->title = new WdsTranslatableText( $key );

		return $this;
	}
}
