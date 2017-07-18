<?php

use Swagger\Client\ExternalAuth\Api\FacebookApi;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Constants;
use Wikia\Service\Swagger\ApiProvider;

trait FacebookApiProvider {
	/** @var FacebookApi $api */
	private $api;

	protected function getApi( int $userId ): FacebookApi {
		if ( !$this->hasValidApi( $userId ) ) {
			/** @var ApiProvider $apiProvider */
			$apiProvider = Injector::getInjector()->get( ApiProvider::class );
			$this->api = $apiProvider->getAuthenticatedApi( 'external-auth', $userId, FacebookApi::class );
		}

		return $this->api;
	}

	private function hasValidApi( int $userId ): bool {
		if ( empty( $this->api ) ) {
			return false;
		}

		$config = $this->api->getApiClient()->getConfig();
		return $config->getApiKey( Constants::HELIOS_AUTH_HEADER ) === $userId;
	}
}
