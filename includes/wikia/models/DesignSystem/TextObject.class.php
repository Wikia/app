<?php

class TextObject {
	const TYPE = 'text';
	private $value;

	public function __construct( $value ) {
		$this->value = $value;
	}

	public function get() {
		return [
			'type' => self::TYPE,
			'value' => $this->value
		];
	}
}