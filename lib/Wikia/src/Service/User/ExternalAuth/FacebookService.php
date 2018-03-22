<?php

namespace Wikia\Service\User\ExternalAuth;

use Swagger\Client\ExternalAuth\Api\FacebookApi;
use Swagger\Client\ExternalAuth\Models\LinkedFacebookAccount;
use User;
use Wikia\Service\Swagger\ApiProvider;

class FacebookService {
	const EXTERNAL_AUTH_SERVICE = 'external-auth';

	/** @var ApiProvider $apiProvider */
	private $apiProvider;

	public function __construct( ApiProvider $apiProvider ) {
		$this->apiProvider = $apiProvider;
	}

	public function unlinkAccount( User $user ) {
		$userId = $user->getId();

		$this->getFacebookApi( $userId )->unlinkAccount( $userId );
	}

	public function linkAccount( User $user, string $accessToken ) {
		$userId = $user->getId();

		$this->getFacebookApi( $userId )->linkAccount( $userId, $accessToken );
	}

	public function getExternalIdentity( User $user ): LinkedFacebookAccount {
		return $this->getFacebookApi( $user->getId() )->me();
	}

	private function getFacebookApi( int $userId ): FacebookApi {
		return $this->apiProvider->getAuthenticatedApi( static::EXTERNAL_AUTH_SERVICE, $userId, FacebookApi::class );
	}
}
