<?php

namespace Wikia\Service\User\Preferences;

interface PreferenceService {
	public function getPreferences( $userId );
	public function getGlobalPreference( $userId, $name, $default = null, $ignoreHidden = false );
	public function setGlobalPreference( $userId, $name, $value );
	public function deleteGlobalPreference( $userId, $name );
	public function getLocalPreference( $userId, $wikiId, $name, $default = null, $ignoreHidden = false );
	public function setLocalPreference( $userId, $wikiId, $name, $value );
	public function deleteLocalPreference( $userId, $name, $wikiId );
	public function save( $userId );
	public function getFromDefault( $pref );
}
