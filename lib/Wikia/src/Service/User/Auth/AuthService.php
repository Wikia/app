<?php

namespace Wikia\Service\User\Auth;

interface AuthService {

	/**
	 * Perform logout action
	 *
	 * @return mixed
	 */

	public function logout();

	/**
	 * Given a username, determine if the user is blocked.
	 *
	 * @param string $username
	 * @return bool true if blocked, false if not, null if the user is not found
	 */
	public function isUsernameBlocked( $username );
}
