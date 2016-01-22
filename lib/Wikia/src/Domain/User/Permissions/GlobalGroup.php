<?php

namespace Wikia\Domain\User\Permissions;

use Wikia\Util\Assert;

class GlobalGroup {

	private $name;

	function __construct( $name) {
		Assert::true( !empty( $name ), "invalid group name" );

		$this->name = $name;
	}

	public function getName() {
		return $this->name;
	}
}
