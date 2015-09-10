<?php

namespace Wikia\Domain\User;

use Wikia\Util\Assert;

class GlobalPreference {

	private $name;
	private $value;

	function __construct( $name, $value ) {
		Assert::true(!empty($name), "invalid preference name");

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
