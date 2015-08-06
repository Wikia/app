<?php

namespace Wikia\Persistence\User\Attributes;

use Wikia\Domain\User\Attribute;
use Wikia\Service\PersistenceException;
use Wikia\Service\UnauthorizedException;

interface AttributePersistence {

	/**
	 * Save the user's attribute.
	 *
	 * @param int $userId
	 * @param Attribute $attribute
	 * @return true success, false or exception otherwise
	 * @throws PersistenceException
	 * @throws UnauthorizedException
	 */
	public function saveAttribute( $userId, $attribute );

	/**
	 * Get the user's attributes.
	 *
	 * @param int $userId
	 * @return array of Attribute objects
	 * @throws UnauthorizedException
	 * @throws PersistenceException
	 */
	public function getAttributes( $userId );

	/**
	 * Delete the user's attribute
	 *
	 * @param int $userId
	 * @param Attribute $attribute
	 * @return true success, exception otherwise
	 */
	public function deleteAttribute( $userId, $attribute );

}
