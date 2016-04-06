<?php

namespace Wikia\Domain\User\Preferences;

class UserPreferences {

	/** @var boolean */
	private $readOnly = false;

	/** @var GlobalPreference[] */
	private $globalPreferences;

	/** @var array[wikiId => [name => LocalPreference]] */
	private $localPreferences;

	function __construct() {
		$this->globalPreferences = [];
		$this->localPreferences = [];
	}

	public function setGlobalPreference( $name, $value ) {
		$this->globalPreferences[$name] = new GlobalPreference( $name, $value );
		return $this;
	}

	public function setLocalPreference( $name, $wikiId, $value ) {
		$this->localPreferences[$wikiId][$name] = new LocalPreference( $name, $value, $wikiId );
		return $this;
	}

	public function getGlobalPreference( $name ) {
		if ( $this->hasGlobalPreference( $name ) ) {
			return $this->globalPreferences[$name]->getValue();
		}

		return null;
	}

	public function getLocalPreference( $name, $wikiId ) {
		if ( $this->hasLocalPreference( $name, $wikiId ) ) {
			return $this->localPreferences[$wikiId][$name]->getValue();
		}

		return null;
	}

	public function deleteGlobalPreference( $name ) {
		unset( $this->globalPreferences[$name] );
	}

	public function deleteLocalPreference( $name, $wikiId ) {
		unset( $this->localPreferences[$wikiId][$name] );

		if ( isset( $this->localPreferences[$wikiId] ) &&
			count( $this->localPreferences[$wikiId] ) == 0 ) {

			unset( $this->localPreferences[$wikiId] );
		}
	}

	public function hasGlobalPreference( $name ) {
		return isset( $this->globalPreferences[$name] );
	}

	public function hasLocalPreference( $name, $wikiId ) {
		return isset( $this->localPreferences[$wikiId][$name] );
	}

	public function isEmpty() {
		return count( $this->globalPreferences ) == 0 && count( $this->localPreferences ) == 0;
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

	/**
	 * Return all local preferences for specific wiki
	 *
	 * @param $wikiId
	 * @return LocalPreference[]
	 */
	public function getLocalPreferencesForWiki( $wikiId ) {
		if ( isset( $this->localPreferences[ $wikiId ] ) && is_array( $this->localPreferences[ $wikiId ] ) ) {
			return array_values( $this->localPreferences[ $wikiId ] );
		}
		return [ ];
	}

	/**
	 * This toggle is to flag the object as being not suitable for saving.
	 *
	 * @param boolean state true to set the preferences to read only
	 */
	public function setReadOnly( $state ) {
		$this->readOnly = $state;
		return $this;
	}

	/**
	 * @return boolean the read only state
	 */
	public function isReadOnly() {
		return $this->readOnly;
	}
}
