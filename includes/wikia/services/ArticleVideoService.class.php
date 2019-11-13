<?php

use Swagger\Client\ApiException;
use Swagger\Client\ArticleVideo\Api\MappingsInternalV2Api;
use Swagger\Client\ArticleVideo\Models\Mapping;
use Swagger\Client\ArticleVideo\Models\MediaIdsForProductResponse;
use Wikia\Factory\ServiceFactory;
use Wikia\Logger\WikiaLogger;

/**
 * Created by PhpStorm.
 * User: ryba
 * Date: 11/12/2017
 * Time: 12:24
 */
class ArticleVideoService {
	const SERVICE_NAME = 'article-video';
	const INTERNAL_REQUEST_HEADER = 'X-Wikia-Internal-Request';

	private static $articleVideoApiClient = null;

	/**
	 * @param $cityId
	 *
	 * @return Mapping[]
	 * @internal param $pageId
	 *
	 */
	public static function getFeaturedVideosForWiki( string $cityId ): MediaIdsForProductResponse {
		$key = self::getMemCacheKey( $cityId );

		return WikiaDataAccess::cacheWithOptions(
			$key,
			function () use ( $cityId ) {
				$api = self::getMappingsInternalApiClient();
				$api->getApiClient()->getConfig()->setApiKey( self::INTERNAL_REQUEST_HEADER, '1' );
				$mappings =
					new MediaIdsForProductResponse( [
						'product' => $cityId,
						'default_media_id' => '',
						'mappings' => [],
					] );

				try {
					list( $response, $code ) = $api->getMediaIdsForProductWithHttpInfo( $cityId );

					if ( $code == 200 ) {
						$mappings = $response;
					}
				} catch ( ApiException $apiException ) {
					WikiaLogger::instance()->debug(
						'could not fetch data from article-video service',
						[
							'exception' => $apiException,
							'status_code' => intval( $apiException->getCode() )
						]
					);
				}

				return $mappings;
			},
			[
				'command' => WikiaDataAccess::USE_CACHE,
				'cacheTTL' => WikiaResponse::CACHE_SHORT,
				'negativeCacheTTL' => WikiaResponse::CACHE_VERY_SHORT
			]
		);
	}

	/**
	 * @param $cityId
	 * @param $pageId
	 *
	 * @return string - mediaId of featured video for given video if exists, empty string otherwise
	 */
	public static function getFeatureVideoForArticle( string $cityId, string $pageId ): string {
		$videos = self::getFeaturedVideosForWiki( $cityId );
		$mediaId = $videos['defaultMediaId'] ?? '';

		if ( isset( $videos['mappings'][$pageId] ) ) {
			$mediaId = $videos['mappings'][$pageId];
		}

		return $mediaId;
	}

	public static function purgeVideoMemCache( $cityId ) {
		$key = self::getMemCacheKey($cityId);

		WikiaDataAccess::cachePurge($key);
	}

	private static function getMemCacheKey( $cityId ) {
		return wfMemcKey( 'article-video', 'get-for-product-v2', $cityId );
	}
	/**
	 * Get Swagger-generated API client
	 *
	 * @return MappingsInternalV2Api
	 */
	private static function getMappingsInternalApiClient(): MappingsInternalV2Api {
		if ( is_null( self::$articleVideoApiClient ) ) {
			self::$articleVideoApiClient = self::createMappingsInternalApiClient();
		}

		return self::$articleVideoApiClient;
	}

	/**
	 * Create Swagger-generated API client
	 *
	 * @return MappingsInternalV2Api
	 */
	private static function createMappingsInternalApiClient(): MappingsInternalV2Api {
		$apiProvider = ServiceFactory::instance()->providerFactory()->apiProvider();
		$api = $apiProvider->getApi( self::SERVICE_NAME, MappingsInternalV2Api::class );

		// default CURLOPT_TIMEOUT for API client is set to 0 which means no timeout.
		// Overwriting to minimal value which is 1.
		// cURL function is allowed to execute not longer than 1 second
		$api->getApiClient()->getConfig()->setCurlTimeout( 1 );

		return $api;
	}
}
