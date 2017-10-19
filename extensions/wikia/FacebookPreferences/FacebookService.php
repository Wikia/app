<?php

use Swagger\Client\ExternalAuth\Models\LinkedFacebookAccount;

class FacebookService {
	/** @var FacebookApiFactory $facebookApiFactory */
	private $facebookApiFactory;

	/**
	 * @Inject
	 * @param FacebookApiFactory $factory
	 */
	public function __construct( FacebookApiFactory $factory ) {
		$this->facebookApiFactory = $factory;
	}

	public function unlinkAccount( User $user ) {
		$userId = $user->getId();

		$this->facebookApiFactory->getApi( $userId )->unlinkAccount( $userId );
	}

	public function linkAccount( User $user, string $accessToken ) {
		$userId = $user->getId();

		$this->facebookApiFactory->getApi( $userId )->linkAccount( $userId, $accessToken );
	}

	public function getExternalIdentity( User $user ): LinkedFacebookAccount {
		return $this->facebookApiFactory->getApi( $user->getId() )->me();
	}
}
