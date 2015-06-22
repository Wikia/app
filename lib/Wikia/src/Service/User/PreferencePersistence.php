<?php

namespace Wikia\Service\User;

interface PreferencePersistence {

	/**
	 * Save the users preferences.
	 *
	 * @param int $userId
	 * @param array [\Wikia\Domain\User\Preference, ... ]
	 * @return true success, false or exception otherwise
	 */
	public function save( int $userId, array $preferences );

	/**
	 * Get the users preferences.
	 *
	 * @param int $userId
	 * @return array of maps of the form {"name": <name>, "value", <value>}
	 */
	public function get( int $userId );

}
