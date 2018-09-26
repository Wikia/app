<?php

use Swagger\Client\ApiException;
use Swagger\Client\WikiRecommendations\Api\InternalWikiRecommendationsApi;
use Swagger\Client\WikiRecommendations\Models\Wiki;
use Wikia\Factory\ServiceFactory;
use Wikia\Logger\WikiaLogger;

/**
 * Created by PhpStorm.
 * User: ryba
 * Date: 11/12/2017
 * Time: 12:24
 */
class WikiRecommendationsService {
	const SERVICE_NAME = 'wiki-recommendations';
	const INTERNAL_REQUEST_HEADER = 'X-Wikia-Internal-Request';
	const MEMCACHE_KEY = 'wiki-recommendations';

	private static $wikiRecommendationsApiClient = null;

	public static function getWikiRecommendations(): array {

		return WikiaDataAccess::cacheWithOptions(
			self::MEMCACHE_KEY,
			function () {
				$api = self::getRecommendationsInternalApiClient();
				$api->getApiClient()->getConfig()->setApiKey( self::INTERNAL_REQUEST_HEADER, '1' );
				$wikis = [];

				try {
					list( $response, $code ) = $api->getWikisWithHttpInfo();

					if ( $code == 200 ) {
						/* @var $wiki Wiki */
						foreach ( $response as $wiki ) {
							$wikis[strtolower( $wiki->getLanguage() )][] = $wiki;
						}
					}
				} catch ( ApiException $apiException ) {
					WikiaLogger::instance()->debug(
						'could not fetch data from wiki-recommendations service',
						[
							'exception' => $apiException,
							'status_code' => intval( $apiException->getCode() )
						]
					);
				}

				return $wikis;
			},
			[
				'command' => WikiaDataAccess::USE_CACHE,
				'cacheTTL' => WikiaResponse::CACHE_SHORT,
				'negativeCacheTTL' => WikiaResponse::CACHE_VERY_SHORT
			]
		);
	}

	/**
	 * @param string $langCode
	 * @param int $maxCount
	 *
	 * @return array - array of Swagger\Client\WikiRecommendations\Models\Wiki with $maxCount recommendations for given
	 *     language
	 */
	public static function getWikiRecommendationsForLanguage( string $langCode, int $maxCount ): array {
		$languageCode = self::fallbackToSupportedLanguages( strtolower( $langCode ) );
		$result = [];
		$recommendations = self::getWikiRecommendations();

		if ( array_key_exists( $languageCode, $recommendations ) ) {
			$result = $recommendations[$languageCode];
		} elseif ( array_key_exists( 'en', $recommendations ) ) {
			$result = $recommendations['en'];
		}

		shuffle( $result );

		return array_slice( $result, 0, $maxCount );
	}

	private static function fallbackToSupportedLanguages( $langCode ) {
		switch ( $langCode ) {
			case 'pt':
				return 'pt-br';
			case 'zh-tw':
			case 'zh-hk':
				return 'zh';
			case 'be':
			case 'kk':
			case 'uk':
				return 'ru';
			default:
				return $langCode;
		}
	}

	/**
	 * Get Swagger-generated API client
	 *
	 * @return InternalWikiRecommendationsApi
	 */
	private static function getRecommendationsInternalApiClient(): InternalWikiRecommendationsApi {
		if ( is_null( self::$wikiRecommendationsApiClient ) ) {
			self::$wikiRecommendationsApiClient = self::createRecommendationsInternalApiClient();
		}

		return self::$wikiRecommendationsApiClient;
	}

	/**
	 * Create Swagger-generated API client
	 *
	 * @return InternalWikiRecommendationsApi
	 */
	private static function createRecommendationsInternalApiClient(): InternalWikiRecommendationsApi {
		$apiProvider = ServiceFactory::instance()->providerFactory()->apiProvider();
		$api = $apiProvider->getApi( self::SERVICE_NAME, InternalWikiRecommendationsApi::class );

		// default CURLOPT_TIMEOUT for API client is set to 0 which means no timeout.
		// Overwriting to minimal value which is 1.
		// cURL function is allowed to execute not longer than 1 second
		$api->getApiClient()->getConfig()->setCurlTimeout( 1 );

		return $api;
	}
}
