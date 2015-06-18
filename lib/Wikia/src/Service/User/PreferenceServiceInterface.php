<?php

namespace Wikia\Service\User;

interface PreferenceServiceInterface {

	public function setPreference( $userId, \Wikia\Domain\User\Preference $preference );
	public function setPreferences( $userId, $preferences );
	public function getPreference( $userId );

}
