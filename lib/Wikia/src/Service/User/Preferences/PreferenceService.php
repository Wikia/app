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
	public function deleteAllPreferences( $userId );
	public function findWikisWithLocalPreferenceValue( $preferenceName, $value );
	public function findUsersWithGlobalPreferenceValue( $preferenceName, $value = null );
	public function save( $userId );
	public function getGlobalDefault( $pref );
	public function deleteFromCache( $userId );
}
