<?php

use Swagger\Client\ExternalAuth\Api\FacebookApi;
use Wikia\Service\Swagger\ApiProvider;

class FacebookApiFactory {
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

	public function getApi( int $userId = 0 ): FacebookApi {
		if ( $userId === 0 ) {
			return $this->apiProvider->getApi( static::EXTERNAL_AUTH_SERVICE, FacebookApi::class );
		}

		return $this->apiProvider->getAuthenticatedApi( static::EXTERNAL_AUTH_SERVICE, $userId, FacebookApi::class );
	}
}
