<?php

namespace Wikia\Domain\User\Permissions;

use Wikia\Util\Assert;

class LocalGroup {

	private $name;
	private $wikiId;

	function __construct( $name, $wikiId ) {
		Assert::true( !empty( $name ), "invalid group name" );
		Assert::true( !empty( $wikiId ), "invalid wiki id" );

		$this->name = $name;
		$this->wikiId = $wikiId;
	}

	public function getName() {
		return $this->name;
	}

	public function getWikiId() {
		return $this->wikiId;
	}
}
