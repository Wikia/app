<?php

class WdsText {
	public $type = 'text';
	public $value;

	public function __construct( $value ) {
		$this->value = $value;
	}
}
