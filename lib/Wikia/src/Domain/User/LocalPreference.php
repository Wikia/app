<?php

namespace Wikia\Domain\User;

use Wikia\Util\Assert;

class LocalPreference {

	private $name;
	private $value;
	private $wikiId;

	function __construct( $name, $value, $wikiId ) {
		Assert::true(!empty($name), "invalid preference name");
		Assert::true(!empty($wikiId), "invalid wiki id");

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

	public function setValue($value) {
		$this->value = $value;
	}
}
