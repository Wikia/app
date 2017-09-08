<?php

use Liftigniter\Metadata\Api\ItemsInternalApi;
use Liftigniter\Metadata\Models\Item;
use Swagger\Client\ApiException;
use Wikia\DependencyInjection\Injector;
use Wikia\Logger\WikiaLogger;
use Wikia\Service\Swagger\ApiProvider;

/**
 * Created by PhpStorm.
 * User: ryba
 * Date: 07/09/2017
 * Time: 17:44
 */

class LiftigniterMetadataService {
	const SERVICE_NAME = 'liftigniter-metadata';
	const INTERNAL_REQUEST_HEADER = 'X-Wikia-Internal-Request';

	private $imageApiClient = null;

	/**
	 * @param $cityId
	 * @param $pageId
	 *
	 * @return Item on success, null otherwise
	 */
	public function getLiMetadataForArticle( $cityId, $pageId): Item {
		$api = $this->getItemsInternalApiClient();
		$api->getApiClient()
			->getConfig()
			->setApiKey(self::INTERNAL_REQUEST_HEADER, '1' );

		try {
			return $api->getItem( $cityId, $pageId );
		} catch ( ApiException $e ) {
			$code = $e->getCode();

			if (intval($code) != 404) {
				WikiaLogger::instance()->debug( 'could not fetch data from liftigniter-metadata service', [
					'exception' => $e,
					'wiki_id' => intval( $cityId ),
					'page_id' => intval( $pageId )
				] );
			}
		}

		return null;
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
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get(ApiProvider::class);
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