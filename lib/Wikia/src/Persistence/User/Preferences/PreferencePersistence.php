<?php

namespace Wikia\Persistence\User\Preferences;

use Wikia\Domain\User\GlobalPreference;
use Wikia\Domain\User\Preferences;
use Wikia\Service\PersistenceException;
use Wikia\Service\UnauthorizedException;

interface PreferencePersistence {

	/**
	 * Save the users preferences.
	 *
	 * @param int $userId
	 * @param Preferences $preferences
	 * @return true success, false or exception otherwise
	 * @throws PersistenceException
	 * @throws UnauthorizedException
	 */
	public function save( $userId, Preferences $preferences );

	/**
	 * Get the users preferences.
	 *
	 * @param int $userId
	 * @return Preferences
	 * @throws UnauthorizedException
	 * @throws PersistenceException
	 */
	public function get( $userId );
}
