<?php

namespace Wikia\Persistence\User\Preferences;

use Wikia\Domain\User\Preference;

interface PreferencePersistence {

	/**
	 * Save the users preferences.
	 *
	 * @param int $userId
	 * @param Preference[] $preferences
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
