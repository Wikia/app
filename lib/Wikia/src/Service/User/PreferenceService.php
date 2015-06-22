<?php

namespace Wikia\Service\User;

interface PreferenceService {

	public function setPreferences( $userId, $preferences );
	public function getPreferences( $userId );

}
