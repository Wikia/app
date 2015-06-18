<?php

namespace Wikia\Service\User;

interface PreferenceServiceInterface {

	public function setPreferences( $userId, $preferences );
	public function getPreferences( $userId );

}
