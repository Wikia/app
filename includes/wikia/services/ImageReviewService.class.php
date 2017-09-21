<?php

use Swagger\Client\ImageReview\Api\ImageApi;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;


class ImageReviewService {
	const SERVICE_NAME = 'image-review';

	private $imageApiClient = null;

	public function getImageHistory( $cityId, $pageId, $revisionId, User $user ):array {
		$api = $this->getImageApiClient();
		$api->getApiClient()
			->getConfig()
			->setApiKey('X-Wikia-UserId', $user->getId() );

		try {
			return $api->getImageHistory( "mw-${cityId}-${pageId}-${revisionId}" );
		} catch ( \Swagger\Client\ApiException $e ) {

			\Wikia\Logger\WikiaLogger::instance()->error( 'Failed to contact Image Review service', [
				'exception' => $e,
				'wiki_id' => intval( $cityId ),
				'page_id' => intval( $pageId ),
				'revision_id' => intval( $revisionId )
			] );
		}

		return [];
	}

	/**
	 * Get Swagger-generated API client
	 *
	 * @return ImageApi
	 */
	private function getImageApiClient() {
		if ( is_null( $this->imageApiClient ) ) {
			$this->imageApiClient = $this->createImageApiClient();
		}

		return $this->imageApiClient;
	}

	/**
	 * Create Swagger-generated API client
	 *
	 * @return ImageApi
	 */
	private function createImageApiClient() {
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get(ApiProvider::class);
		$api = $apiProvider->getApi( self::SERVICE_NAME, ImageApi::class );

		// default CURLOPT_TIMEOUT for API client is set to 0 which means no timeout.
		// Overwriting to minimal value which is 1.
		// cURL function is allowed to execute not longer than 1 second
		$api->getApiClient()
			->getConfig()
			->setCurlTimeout(1);

		return $api;
	}
}