<?php
namespace Wikia\CreateNewWiki;

use User;

class UserValidator {
	const MAX_WIKI_CREATIONS_PER_USER_PER_DAY = 2;

	/** @var UserValidatorProxy $userValidatorProxy */
	private $userValidatorProxy;

	/**
	 * @Inject
	 * @param UserValidatorProxy $proxy
	 */
	public function __construct( UserValidatorProxy $proxy ) {
		$this->userValidatorProxy = $proxy;
	}

	/**
	 * @param User $user
	 * @return bool
	 * @throws NotLoggedInException
	 */
	public function assertLoggedIn( User $user ): bool {
		if ( !$user->isLoggedIn() ) {
			throw new NotLoggedInException( $user );
		}

		return true;
	}

	/**
	 * @param User $user
	 * @return bool
	 * @throws EmailNotConfirmedException
	 */
	public function assertEmailConfirmed( User $user ): bool {
		if ( !$user->isEmailConfirmed() ) {
			throw new EmailNotConfirmedException();
		}

		return true;
	}

	/**
	 * @param User $user
	 * @return bool
	 * @throws UserBlockedException
	 */
	public function assertNotBlocked( User $user ): bool {
		if ( $user->isBlocked() ) {
			throw new UserBlockedException( $user );
		}

		return true;
	}

	public function assertNotExceededRateLimit( User $user ): bool {
		if (
			!$user->isPingLimitable() &&
			!$user->isAllowed( 'createwikilimitsexempt' ) &&
			$this->userValidatorProxy->getWikiCreationsToday( $user ) >= static::MAX_WIKI_CREATIONS_PER_USER_PER_DAY
		){
			throw new RateLimitedException();
		}

		return true;
	}
}
