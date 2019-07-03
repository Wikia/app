<?php

namespace Wikia\Search\UnifiedSearch;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use RequestContext;
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

	public function useUnifiedSearch( bool $isCorporateWiki ): bool {
		global $wgUseUnifiedSearch;

		/** This is cross-wiki search - we don't support it yet. */
		if ( $isCorporateWiki ) {
			return false;
		}

		$queryForce = RequestContext::getMain()->getRequest()->getVal( 'useUnifiedSearch', null );
		if ( !is_null( $queryForce ) ) {
			return $queryForce === 'true' || $queryForce === '1' || $queryForce === true;
		}

		return $wgUseUnifiedSearch;
	}

	/**
	 * SER-3306 - Fire and forget call to unified-search to test if unified-search is able to sustain our load.
	 * Will be replaced with real calls in https://wikia-inc.atlassian.net/browse/SER-3313
	 * @param UnifiedSearchRequest $request
	 */
	public function shadowModeSearch( UnifiedSearchRequest $request ) {
		try {
			$params = [
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

			$client = new Client( [
				// Base URI is used with relative requests
				'base_uri' => $this->baseUrl,
				// connect timeout is sufficient enough to make the request
				// short read timeout will cause the request to be interrupted immediately after being started
				// https://github.com/guzzle/guzzle/issues/1429#issuecomment-304449743
				'read_timeout' => 0.0000001,
				'connect_timeout' => 2.0,
				'query_with_duplicates' => true,
			] );

			$client->get( 'page-search', [
				// we want namespace to be passed multiple times
				// for example ?namespace=1&namespace=0
				// normally, it would have been converted to ?namespace[]=1&namespace[]=0
				'query' => build_query( $params, PHP_QUERY_RFC1738 ),
			] );
		}
		catch ( \Exception $e ) {
			WikiaLogger::instance()->info( self::FAILED_TO_CALL_UNIFIED_SEARCH, [
				'error_message' => $e->getMessage(),
				'status_code' => $e->getCode(),
			] );
		}
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
