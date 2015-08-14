<?php

namespace Wikia\Service\User\Auth;

class MediaWikiAuthService implements AuthService {


	/**
	 * @see AuthService
	 */
	public function isUsernameBlocked( $username ) {
		$user = \User::newFromName( $username );

		if ( !$user ) {
			return null;
		}

		$user->load();
		if ( $user->getId() == 0 ) {
			return null;
		}

		return $user->isBlocked();
	}

}
