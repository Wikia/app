<?php

use Swagger\Client\ApiException;
use Swagger\Client\UnifiedSearch\Api\UnifiedSearchApi;
use Wikia\Factory\ServiceFactory;
use Wikia\Logger\WikiaLogger;


class UnifiedSearchService {
	const SERVICE_NAME = 'unified-search';

	/**
	 * @var UnifiedSearchApi
	 */
	private $apiClient = null;

	public function query( $wikiId, $languageCode, $query, array $namespaces ): array {
		$api = $this->getImageApiClient();
		try {
			return $api->specialSearchWithHttpInfo( $query, $languageCode, $wikiId, $namespaces );
		}
		catch ( ApiException $e ) {
			WikiaLogger::instance()->error( 'Failed to contact Unified Search service', [
				'exception' => $e,
				'wiki_id' => intval( $wikiId ),
				'languageCode' => $languageCode,
				'query' => $query,
				'namespaces' => $namespaces,
			] );

			return [];
		}
	}

	private function getImageApiClient(): UnifiedSearchApi {
		if ( is_null( $this->apiClient ) ) {
			$this->apiClient = $this->createClient();
		}

		return $this->apiClient;
	}

	private function createClient(): UnifiedSearchApi {
		$apiProvider = ServiceFactory::instance()->providerFactory()->apiProvider();
		$api = $apiProvider->getApi( self::SERVICE_NAME, UnifiedSearchApi::class );

		// default CURLOPT_TIMEOUT for API client is set to 0 which means no timeout.
		// Overwriting to minimal value which is 1.
		// cURL function is allowed to execute not longer than 1 second
		$api->getApiClient()->getConfig()->setCurlTimeout( 1 );

		return $api;
	}
}
