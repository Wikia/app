<?php

namespace Wikia\Service\User\ExternalAuth;

use Swagger\Client\ExternalAuth\Api\FacebookApi;
use Swagger\Client\ExternalAuth\Api\GoogleApi;
use Wikia\Service\Swagger\ApiProvider;

class ExternalAuthApiFactory {
	const EXTERNAL_AUTH_SERVICE = 'external-auth';

	/** @var ApiProvider $apiProvider */
	private $apiProvider;

	/**
	 * @Inject
	 * @param ApiProvider $apiProvider
	 */
	public function __construct( ApiProvider $apiProvider ) {
		$this->apiProvider = $apiProvider;
	}

	public function getFacebookApi( int $userId = 0 ): FacebookApi {
		if ( $userId === 0 ) {
			return $this->apiProvider->getApi( static::EXTERNAL_AUTH_SERVICE, FacebookApi::class );
		}

		return $this->apiProvider->getAuthenticatedApi( static::EXTERNAL_AUTH_SERVICE, $userId, FacebookApi::class );
	}


	public function getGoogleApi( int $userId = 0 ): GoogleApi {
		if ( $userId === 0 ) {
			return $this->apiProvider->getApi( static::EXTERNAL_AUTH_SERVICE, GoogleApi::class );
		}

		return $this->apiProvider->getAuthenticatedApi( static::EXTERNAL_AUTH_SERVICE, $userId, GoogleApi::class );
	}
}
