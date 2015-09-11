<?php

namespace Wikia\Domain\User;

class Preferences {

	/** @var GlobalPreference[] */
	private $globalPreferences;

	/** @var LocalPreference[] */
	private $localPreferences;

	/**
	 * @param GlobalPreference[] $globalPreferences
	 * @param LocalPreference[] $localPreferences
	 */
	function __construct( $globalPreferences = [], $localPreferences = [] ) {
		$this->globalPreferences = $globalPreferences;
		$this->localPreferences = $localPreferences;
	}

	public function setGlobalPreference(GlobalPreference $preference) {
		$this->globalPreferences[$preference->getName()] = $preference;
	}

	public function setLocalPreference(LocalPreference $preference) {
		$this->localPreferences[$preference->getName()] = $preference;
	}

	public function getGlobalPreference($name) {
		if (isset($this->globalPreferences[$name])) {
			return $this->globalPreferences[$name];
		}

		return null;
	}

	/**
	 * @return GlobalPreference[]
	 */
	public function getGlobalPreferences() {
		return $this->globalPreferences;
	}

	/**
	 * @return LocalPreference[]
	 */
	public function getLocalPreferences() {
		return $this->localPreferences;
	}
}
