<?php

namespace Wikia\Service\User;

interface PreferencePersistence {

	/**
	 * Get the Wikia user id on the gateway. This represents the authenticated
	 * user that is being used to make requests.
	 *
	 * @return int
	 */
	public function getWikiaUserId();

	/**
	 * Set the Wikia user id on the gateway. This represents the authenticated
	 * user that is being used to make requests.
	 *
	 * @param int $wikiaUserId
	 */
	public function setWikiaUserId( int $wikiaUserId );

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
