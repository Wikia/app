<?php

namespace Wikia\Service\User;

interface PreferenceService {

	/**
	 * Set preferences for the given user id.
	 *
	 * @param int $userid
	 * @param Preference[] $preferences
	 * @return bool true when saved false otherwise
	 */
	public function setPreferences( $userId, array $preferences );


	/**
	 * Get preferences for a given user id.
	 *
	 * @param int $userid
	 * @return Preference[]
	 */
	public function getPreferences( $userId );

}
