<?php

namespace Wikia\Persistence\User\Preferences;

use Wikia\Domain\User\Preferences\UserPreferences;
use Wikia\Service\PersistenceException;
use Wikia\Service\UnauthorizedException;

interface PreferencePersistence {

	/**
	 * Save the users preferences.
	 *
	 * @param int $userId
	 * @param UserPreferences $preferences
	 * @return true success, false or exception otherwise
	 * @throws PersistenceException
	 * @throws UnauthorizedException
	 */
	public function save( $userId, UserPreferences $preferences );

	/**
	 * Get the users preferences.
	 *
	 * @param int $userId
	 * @return UserPreferences
	 * @throws UnauthorizedException
	 * @throws PersistenceException
	 */
	public function get( $userId );
}
