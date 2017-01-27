<?php

class LineTextObject {
	const TYPE = 'line-text';
	private $title;

	public function __construct() {
	}

	public function setTranslatableTitle( $key ) {
		$this->title = ( new TranslatableTextObject( $key ) )->get();

		return $this;
	}

	public function get() {
		return [
			'type' => self::TYPE,
			'title' => $this->title
		];
	}
}