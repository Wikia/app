<?php

namespace Wikia\Service\User\ExternalAuth;

use Swagger\Client\ExternalAuth\Models\LinkedFacebookAccount;
use User;

class FacebookService {
	/** @var ExternalAuthApiFactory $externalAuthApiFactory */
	private $externalAuthApiFactory;

	/**
	 * @Inject
	 * @param ExternalAuthApiFactory $factory
	 */
	public function __construct( ExternalAuthApiFactory $factory ) {
		$this->externalAuthApiFactory = $factory;
	}

	public function unlinkAccount( User $user ) {
		$userId = $user->getId();

		$this->externalAuthApiFactory->getFacebookApi( $userId )->unlinkAccount( $userId );
	}

	public function linkAccount( User $user, string $accessToken ) {
		$userId = $user->getId();

		$this->externalAuthApiFactory->getFacebookApi( $userId )
			->linkAccount( $userId, $accessToken );
	}

	public function getExternalIdentity( User $user ): LinkedFacebookAccount {
		return $this->externalAuthApiFactory->getFacebookApi( $user->getId() )->me();
	}
}
