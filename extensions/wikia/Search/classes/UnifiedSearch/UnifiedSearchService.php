<?php

namespace Wikia\Search\UnifiedSearch;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Wikia\Factory\ServiceFactory;
use Wikia\Logger\WikiaLogger;
use WikiaException;
use function GuzzleHttp\Psr7\build_query;

class UnifiedSearchService {
	const FAILED_TO_CALL_UNIFIED_SEARCH = "Failed to call unified-search";

	/** @var string */
	private $baseUrl;

	public function __construct() {
		$urlProvider = ServiceFactory::instance()->providerFactory()->urlProvider();
		$this->baseUrl = 'http://' . $urlProvider->getUrl( 'unified-search' ) . '/';
	}

	public function search( UnifiedSearchRequest $request ): UnifiedSearchResult {
		$result = $this->callSpecialSearch( $request );

		$items = [];
		foreach ( $result['results'] as $item ) {
			$items[] = [
				'wid' => $item['wikiId'],
				'pageid' => $item['pageId'],
				'title' => $item['title'],
				'text' => $item['content'],
				'url' => $item['url'],
				'ns' => $item['namespace'],
				'hub_s' => $item['hub'],
			];
		}

		return new UnifiedSearchResult( $result['totalResultsFound'], $result['paging']['total'],
			$result['paging']['current'], $items );
	}


	private function callSpecialSearch( UnifiedSearchRequest $request ) {
		$params = [
			'wikiId' => $request->getWikiId(),
			'lang' => $request->getLanguageCode(),
			'query' => $request->getQuery()->getSanitizedQuery(),
			'namespace' => $request->getNamespaces(),
			'page' => $request->getPage(),
			'limit' => $request->getLimit(),
		];

		if ( $request->isImageOnly() ) {
			$params['imagesOnly'] = 'true';
		}

		if ( $request->isVideoOnly() ) {
			$params['videoOnly'] = 'true';
		}

		$response = $this->doApiRequest( 'page-search', $params );

		return json_decode( $response->getBody(), true );
	}

	/**
	 * @param $uri
	 * @param $params
	 * @return ResponseInterface
	 * @throws WikiaException
	 */
	private function doApiRequest( $uri, $params ): ResponseInterface {
		$client = new Client( [
			// Base URI is used with relative requests
			'base_uri' => $this->baseUrl,
			// You can set any number of default request options.
			'timeout' => 2.0,
			'query_with_duplicates' => true,
		] );

		try {
			return $client->get( $uri, [
				// we want namespace to be passed multiple times
				// for example ?namespace=1&namespace=0
				// normally, it would have been converted to ?namespace[]=1&namespace[]=0
				'query' => build_query( $params, PHP_QUERY_RFC1738 ),
			] );
		}
		catch ( ClientException $e ) {
			WikiaLogger::instance()->error( self::FAILED_TO_CALL_UNIFIED_SEARCH, [
				'error_message' => $e->getMessage(),
				'status_code' => $e->getCode(),
			] );

			throw new WikiaException( self::FAILED_TO_CALL_UNIFIED_SEARCH, 500, $e );
		}
	}

}
