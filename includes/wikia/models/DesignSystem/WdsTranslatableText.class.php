<?php

class WdsTranslatableText {
	public $type = 'translatable-text';
	public $key;

	public function __construct( $key ) {
		$this->key = $key;
	}
}
