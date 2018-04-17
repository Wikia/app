<?php

namespace Wikia\Service\User\Auth;

use Wikia\Factory\ServiceFactory;

trait AuthServiceAccessor {

	/**
	 * @var AuthService
	 */
	private $authenticationService;

	/**
	 * @return AuthService
	 */
	protected function authenticationService(): AuthService {
		if ( is_null( $this->authenticationService ) ) {
			$this->authenticationService = ServiceFactory::instance()->heliosFactory()->authService();
		}

		return $this->authenticationService;
	}
}
