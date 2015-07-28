<?php

namespace Wikia\Service\User\Attributes;

use Wikia\Domain\User\Attribute;

interface AttributeService {

	/**
	 * Set attribute for the given user id.
	 *
	 * @param int $userId
	 * @param Attribute $attribute
	 * @return bool true when saved false otherwise
	 */
	public function setAttribute( $userId, $attribute );


	/**
	 * Get attributes for a given user id.
	 *
	 * @param int $userId
	 * @return Attribute[]
	 */
	public function getAttributes( $userId );

}
