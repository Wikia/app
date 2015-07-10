<?php

namespace Wikia\Persistence\User\Preferences;

use Wikia\Domain\User\Preference;
use Wikia\Service\PersistenceException;
use Wikia\Service\UnauthorizedException;

interface PreferencePersistence {

	/**
	 * Save the users preferences.
	 *
	 * @param int $userId
	 * @param Preference[] $preferences
	 * @return true success, false or exception otherwise
	 * @throws PersistenceException
	 * @throws UnauthorizedException
	 */
	public function save( $userId, array $preferences );

	/**
	 * Get the users preferences.
	 *
	 * @param int $userId
	 * @return array of Preference objects
	 * @throws UnauthorizedException
	 * @throws PersistenceException
	 */
	public function get( $userId );

}
