<?php

namespace Wikia\Domain\User;

class Preferences {

	/** @var GlobalPreference[] */
	private $globalPreferences;

	/** @var array[wikiId => [name => LocalPreference]] */
	private $localPreferences;

	function __construct() {
		$this->globalPreferences = [];
		$this->localPreferences = [];
	}

	public function setGlobalPreference($pref, $value) {
		$this->globalPreferences[$pref] = new GlobalPreference($pref, $value);
	}

	public function setLocalPreference($pref, $wikiId, $value) {
		$this->localPreferences[$wikiId][$pref] = new LocalPreference($pref, $value, $wikiId);
	}

	public function getGlobalPreference($name) {
		if ($this->hasGlobalPreference($name)) {
			return $this->globalPreferences[$name]->getValue();
		}

		return null;
	}

	public function getLocalPreference($name, $wikiId) {
		if ($this->hasLocalPreference($name, $wikiId)) {
			return $this->localPreferences[$wikiId][$name]->getValue();
		}

		return null;
	}

	public function hasGlobalPreference($name) {
		return isset($this->globalPreferences[$name]);
	}

	public function hasLocalPreference($name, $wikiId) {
		return isset($this->localPreferences[$wikiId][$name]);
	}

	public function isEmpty() {
		return count($this->globalPreferences) == 0 && count($this->localPreferences) == 0;
	}

	/**
	 * @return GlobalPreference[]
	 */
	public function getGlobalPreferences() {
		return $this->globalPreferences;
	}

	/**
	 * @return array[wikiId => [name => LocalPreference]]
	 */
	public function getLocalPreferences() {
		return $this->localPreferences;
	}
}
