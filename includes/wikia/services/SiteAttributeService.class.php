<?php

use Swagger\Client\SiteAttribute\Api\SiteAttributeApi;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;

class SiteAttributeService {

	const SERVICE_NAME = 'site-attribute';

	public $apiClient = null;

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

}
