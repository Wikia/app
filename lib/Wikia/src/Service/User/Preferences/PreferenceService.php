<?php

namespace Wikia\Service\User\Preferences;

use Wikia\Domain\User\Preference;

interface PreferenceService {

	/**
	 * Set preferences for the given user id.
	 *
	 * @param int $userId
	 * @param Preference[] $preferences
	 * @return bool true when saved false otherwise
	 */
	public function setPreferences( $userId, array $preferences );


	/**
	 * Get preferences for a given user id.
	 *
	 * @param int $userId
	 * @return Preference[]
	 */
	public function getPreferences( $userId );

}
