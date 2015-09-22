<?php

namespace Wikia\Service\User\Preferences;

use Wikia\Domain\User\Preferences\UserPreferences;

interface PreferenceService {
	/**
	 * @return UserPreferences
	 */
	public function getPreferences( $userId );
	public function setPreferences( $userId, UserPreferences $preferences );
	public function getGlobalPreference( $userId, $name, $default = null, $ignoreHidden = false );
	public function setGlobalPreference( $userId, $name, $value );
	public function deleteGlobalPreference( $userId, $name );
	public function getLocalPreference( $userId, $wikiId, $name, $default = null, $ignoreHidden = false );
	public function setLocalPreference( $userId, $wikiId, $name, $value );
	public function deleteLocalPreference( $userId, $name, $wikiId );
	public function save( $userId );
	public function getGlobalDefault( $pref );
	public function getLocalDefault( $pref, $wikiId );

	/**
	 * TODO: this should be a private method in PreferenceServiceImpl
	 * but need it to be public while we do migrations for false-positive detection
	 */
	public function prefIsSaveable( $pref, $value, $valueFromDefaults );
}
