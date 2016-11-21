<?php

use Swagger\Client\DesignSystem\Api\DSApi;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;

class DesignSystemService {


	const SERVICE_NAME = 'design-system';
	private $apiClient;

	public function getPageHeader() {
		global $wgCityId, $wgLanguageCode;

		return json_decode($this->getApiClient()->getPageHeader( $wgCityId, $wgLanguageCode ), true);
	}

	/**
	 * Get Swagger-generated API client
	 *
	 * @return DSApi
	 */
	private function getApiClient() {
		if ( is_null( $this->apiClient ) ) {
			$this->apiClient = $this->createApiClient();
		}

		return $this->apiClient;
	}

	private function createApiClient() {
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get( ApiProvider::class );
		/** @var DSApi $api */
		$api = $apiProvider->getApi( self::SERVICE_NAME, DSApi::class );

		// default CURLOPT_TIMEOUT for API client is set to 0 which means no timeout.
		// Overwriting to minimal value which is 1.
		// cURL function is allowed to execute not longer than 1 second
		$api->getApiClient()
			->getConfig()
			->setCurlTimeout( 1 );

		return $api;
	}
}
