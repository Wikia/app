<?php

namespace Wikia\Service\User\Auth;

use Wikia\DependencyInjection\Injector;

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
			$this->authenticationService = Injector::getInjector()->get( AuthService::class );
		}

		return $this->authenticationService;
	}
}
