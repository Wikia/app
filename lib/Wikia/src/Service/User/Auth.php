<?php

namespace Wikia\Service\User;

interface Auth {

	/**
	 * Given a username, determine if the user is blocked.
	 *
	 * @param string $username
	 * @return bool true if blocked, false otherwise
	 */
	public function isUsernameBlocked( $username );
}
