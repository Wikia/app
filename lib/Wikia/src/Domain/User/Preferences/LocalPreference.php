<?php

namespace Wikia\Domain\User\Preferences;

use Wikia\Util\Assert;

class LocalPreference {

	private $name;
	private $value;
	private $wikiId;

	function __construct( $name, $value, $wikiId ) {
		Assert::true( !empty( $name ), "invalid preference name" );
		Assert::true( !empty( $wikiId ), "invalid wiki id" );

		if ( $value === "true" ) {
			$value = true;
		} elseif ( $value === "false" ) {
			$value = false;
		}

		$this->name = $name;
		$this->value = $value;
		$this->wikiId = $wikiId;
	}

	public function getName() {
		return $this->name;
	}

	public function getValue() {
		return $this->value;
	}

	public function getWikiId() {
		return $this->wikiId;
	}
}
