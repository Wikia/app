<?php
namespace Wikia\Service\User\Username;

/**
 * Always return fallback.
 *
 * Class FallbackUsernameService
 * @package Wikia\Service\User\Username
 */
class FallbackUsernameService implements UsernameService {

	/**
	 * Always return fallback
	 *
	 * @param $id int
	 * @param $fallback string
	 * @return string username
	 */
	public function getUsername( $id, $fallback ) {

		return $fallback;
	}
}
