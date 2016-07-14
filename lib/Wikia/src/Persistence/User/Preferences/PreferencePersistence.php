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

	/**
	 * delete's all of a user's preferences
	 *
	 * @param $userId
	 * @return bool
	 * @throws UnauthorizedException
	 * @throws PersistenceException
	 */
	public function deleteAll( $userId );

	/**
	 * find wikis where at least one user has a local preference set to a specific value
	 * @param $preferenceName
	 * @param $value
	 * @return string[]
	 * @throws PersistenceException
	 */
	public function findWikisWithLocalPreferenceValue( $preferenceName, $value );

	/**
	 * find users that have a global preference set to a specific value
	 * @param $preferenceName
	 * @param $value
	 * @return string[]
	 * @throws PersistenceException
	 */
	public function findUsersWithGlobalPreferenceValue( $preferenceName, $value );
}
