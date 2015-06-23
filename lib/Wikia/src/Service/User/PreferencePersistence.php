<?php

namespace Wikia\Service\User;

interface PreferencePersistence {

	/**
	 * Save the users preferences.
	 *
	 * @param int $userId
	 * @param Preference[]
	 * @return true success, false or exception otherwise
	 */
	public function save( $userId, array $preferences );

	/**
	 * Get the users preferences.
	 *
	 * @param int $userId
	 * @return array of Preference objects
	 */
	public function get( $userId );

}
