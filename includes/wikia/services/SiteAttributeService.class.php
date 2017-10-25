<?php

use Swagger\Client\ApiException;
use Swagger\Client\SiteAttribute\Api\SiteAttributeApi;
use Wikia\DependencyInjection\Injector;
use Wikia\Logger\Loggable;
use Wikia\Service\Swagger\ApiProvider;

class SiteAttributeService {

	use Loggable;

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

		/** @var SiteAttributeApi $api */
		$api = $apiProvider->getApi( self::SERVICE_NAME, SiteAttributeApi::class );

		// default CURLOPT_TIMEOUT for API client is set to 0 which means no timeout.
		// Overwriting to minimal value which is 1.
		// cURL function is allowed to execute not longer than 1 second
		$api->getApiClient()
			->getConfig()
			->setCurlTimeout(1);

		return $api;
	}

	public function getAttribute($siteId, $attributeName, $default = null) {
		try {
			return $this
							->getApiClient()
							->getAttribute($siteId, $attributeName)
							->getValue() ?? $default;
		} catch (ApiException $e) {
			$this->error(
					"error getting site attribute",
					[
							'site' => $siteId,
							'attribute' => $attributeName,
							'code' => $e->getCode(),
							'message' => $e->getMessage()
					]);
			return $default;
		}
	}

}
