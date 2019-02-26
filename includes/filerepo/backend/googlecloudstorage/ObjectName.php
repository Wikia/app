<?php

class ObjectName {
	/**
	 * @var string
	 */
	private $value;

	public function __construct( string $value ) {
		$this->value = $value;
	}

	public function value() {
		return $this->value;
	}
}
