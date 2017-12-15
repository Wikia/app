<?php

use Swagger\Client\ApiException;
use Swagger\Client\ArticleVideo\Api\MappingsInternalApi;
use Swagger\Client\ArticleVideo\Models\Mapping;
use Wikia\DependencyInjection\Injector;
use Wikia\Logger\WikiaLogger;
use Wikia\Service\Swagger\ApiProvider;

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
	public static function getFeaturedVideosForWiki( string $cityId ): array {
		$key = wfMemcKey( 'article-video', 'get-for-product', $cityId );

		return WikiaDataAccess::cacheWithOptions(
			$key,
			function () use ( $cityId ) {
				$api = self::getMappingsInternalApiClient();
				$api->getApiClient()->getConfig()->setApiKey( self::INTERNAL_REQUEST_HEADER, '1' );
				$mappings = [];

				try {
					list( $response, $code ) = $api->getForProductWithHttpInfo( $cityId );

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
		$mediaId = '';

		$forArticle = array_map(
			function ( Mapping $mapping ) {
				return $mapping->getMediaId();
			},
			array_filter(
				self::getFeaturedVideosForWiki( $cityId ),
				function ( Mapping $mapping ) use ( $pageId ) {
					return $mapping->getId() === (string) $pageId;
				}
			)
		);

		if ( !empty( $forArticle ) ) {
			$mediaId = array_pop( $forArticle );
		}

		return $mediaId;
	}

	/**
	 * Get Swagger-generated API client
	 *
	 * @return MappingsInternalApi
	 */
	private static function getMappingsInternalApiClient(): MappingsInternalApi {
		if ( is_null( self::$articleVideoApiClient ) ) {
			self::$articleVideoApiClient = self::createMappingsInternalApiClient();
		}

		return self::$articleVideoApiClient;
	}

	/**
	 * Create Swagger-generated API client
	 *
	 * @return MappingsInternalApi
	 */
	private static function createMappingsInternalApiClient(): MappingsInternalApi {
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get( ApiProvider::class );
		$api = $apiProvider->getApi( self::SERVICE_NAME, MappingsInternalApi::class );

		// default CURLOPT_TIMEOUT for API client is set to 0 which means no timeout.
		// Overwriting to minimal value which is 1.
		// cURL function is allowed to execute not longer than 1 second
		$api->getApiClient()->getConfig()->setCurlTimeout( 1 );

		return $api;
	}
}