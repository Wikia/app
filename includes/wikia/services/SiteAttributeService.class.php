<?php

use Swagger\Client\SiteAttribute\Api\SiteAttributeApi;
use \Swagger\Client\SiteAttribute\Api\SiteAttributeInternalApi;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;

class SiteAttributeService {

	const SERVICE_NAME = 'site-attribute';

	public $apiClient = null;
	public $authenticatedApiClient = null;

	/**
	 * Get Swagger-generated API client
	 *
	 * @return SiteAttributeApi
	 */
	public function getApiClient() {
		if ( is_null( $this->apiClient ) ) {
			$this->apiClient = $this->createApiClient();
		}

		return $this->apiClient;
	}

	/**
	 * Get Swagger-generated authenticated API client
	 *
	 * @return SiteAttributeInternalApi
	 */
	public function getAuthenticatedInternalApiClient() {
		if ( is_null( $this->authenticatedApiClient ) ) {
			$this->authenticatedApiClient = $this->createAuthenticatedInternalApiClient();
		}

		return $this->authenticatedApiClient;
	}

	/**
	 * Create Swagger-generated API client
	 *
	 * @return SiteAttributeApi
	 */
	public function createApiClient() {
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get(ApiProvider::class);
		$api = $apiProvider->getApi( self::SERVICE_NAME, SiteAttributeApi::class );

		// default CURLOPT_TIMEOUT for API client is set to 0 which means no timeout.
		// Overwriting to minimal value which is 1.
		// cURL function is allowed to execute not longer than 1 second
		$api->getApiClient()
			->getConfig()
			->setCurlTimeout(1);

		return $api;
	}

	/**
	 * Create Swagger-generated API client
	 *
	 * @return SiteAttributeInternalApi
	 */
	public function createAuthenticatedInternalApiClient() {
		global $wgUser;
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get(ApiProvider::class);
		$api = $apiProvider->getAuthenticatedApi( self::SERVICE_NAME, $wgUser->getId(), SiteAttributeInternalApi::class);

		// default CURLOPT_TIMEOUT for API client is set to 0 which means no timeout.
		// Overwriting to minimal value which is 1.
		// cURL function is allowed to execute not longer than 1 second
		$api->getApiClient()
			->getConfig()
			->setCurlTimeout(1);

		return $api;
	}

}
