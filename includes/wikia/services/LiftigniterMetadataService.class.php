<?php

use Swagger\Client\Liftigniter\Metadata\Api\ItemsInternalApi;
use Swagger\Client\Liftigniter\Metadata\Models\Item;
use Swagger\Client\ApiException;
use Wikia\Factory\ServiceFactory;
use Wikia\Logger\WikiaLogger;

class LiftigniterMetadataService {
	const SERVICE_NAME = 'liftigniter-metadata';
	const INTERNAL_REQUEST_HEADER = 'X-Wikia-Internal-Request';

	private $imageApiClient = null;

	/**
	 * @param $cityId
	 * @param $pageId
	 *
	 * @return null|Item[]
	 */
	public function getLiMetadata() {
		$api = $this->getItemsInternalApiClient();
		$api->getApiClient()
			->getConfig()
			->setApiKey(self::INTERNAL_REQUEST_HEADER, '1' );

		$item = null;

		try {
			list($response, $code) = $api->getAllWithHttpInfo();

			if ( $code == 200 ) {
				$item = $response;
			}
		} catch ( ApiException $apiException ) {
			WikiaLogger::instance()->debug( 'could not fetch data from liftigniter-metadata service', [
				'exception' => $apiException,
				'status_code' => intval( $apiException->getCode() )
			] );
		}

		return $item;
	}

	/**
	 * Get Swagger-generated API client
	 *
	 * @return ItemsInternalApi
	 */
	private function getItemsInternalApiClient(): ItemsInternalApi {
		if ( is_null( $this->imageApiClient ) ) {
			$this->imageApiClient = $this->createItemsInternalApiClient();
		}

		return $this->imageApiClient;
	}

	/**
	 * Create Swagger-generated API client
	 *
	 * @return ItemsInternalApi
	 */
	private function createItemsInternalApiClient(): ItemsInternalApi {
		$apiProvider = ServiceFactory::instance()->providerFactory()->apiProvider();
		$api = $apiProvider->getApi( self::SERVICE_NAME, ItemsInternalApi::class );

		// default CURLOPT_TIMEOUT for API client is set to 0 which means no timeout.
		// Overwriting to minimal value which is 1.
		// cURL function is allowed to execute not longer than 1 second
		$api->getApiClient()
			->getConfig()
			->setCurlTimeout(1);

		return $api;
	}
}
