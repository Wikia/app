<?php

namespace Wikia\Service\User\ExternalAuth;

use Swagger\Client\ExternalAuth\Api\GoogleApi;
use User;
use Wikia\Service\Swagger\ApiProvider;

class GoogleService {
	/** @var ApiProvider $apiProvider */
	private $apiProvider;

	public function __construct( ApiProvider $apiProvider ) {
		$this->apiProvider = $apiProvider;
	}

	public function unlinkAccount( User $user ) {
		$userId = $user->getId();

		$this->apiProvider->getAuthenticatedApi( 'external-auth', $userId, GoogleApi::class )
			->unlinkAccount( $userId );
	}
}
