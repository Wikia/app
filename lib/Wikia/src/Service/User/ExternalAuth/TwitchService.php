<?php

namespace Wikia\Service\User\ExternalAuth;

use Swagger\Client\ExternalAuth\Api\TwitchApi;
use User;
use Wikia\Service\Swagger\ApiProvider;

class TwitchService {
	/** @var ApiProvider $apiProvider */
	private $apiProvider;

	public function __construct( ApiProvider $apiProvider ) {
		$this->apiProvider = $apiProvider;
	}

	public function unlinkAccount( User $user ) {
		$userId = $user->getId();

		$this->apiProvider->getAuthenticatedApi( 'external-auth', $userId, TwitchApi::class )
			->unlinkAccount( $userId );
	}
}
