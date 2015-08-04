<?php

namespace Wikia\Domain\User;

class Attribute {

	private $name;
	private $value;

	function __construct( $name, $value ) {
		$this->name = $name;
		$this->value = $value;
	}

	public function getName() {
		return $this->name;
	}

	public function getValue() {
		return $this->value;
	}

}
