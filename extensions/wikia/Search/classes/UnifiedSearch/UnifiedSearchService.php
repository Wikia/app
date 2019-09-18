<?php

namespace Wikia\Search\UnifiedSearch;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Wikia\Factory\ServiceFactory;
use Wikia\Logger\WikiaLogger;
use WikiaException;
use WikiFactory;
use function GuzzleHttp\Psr7\build_query;

class UnifiedSearchService {
	const FAILED_TO_CALL_UNIFIED_SEARCH = "Failed to call unified-search";
	const SEARCH_TYPE_PAGE = 'page';
	const SEARCH_TYPE_COMMUNITY = 'community';

	const COMMUNITY_FIELDS = [
		'id',
		'title',
		'description',
		'language',
		'url',
		'image',
		'hub_s',
		'articles_i',
		'images_i',
		'videos_i',
	];

	/** @var string */
	private $baseUrl;

	public function __construct() {
		$urlProvider = ServiceFactory::instance()->providerFactory()->urlProvider();
		$this->baseUrl = 'http://' . $urlProvider->getUrl( 'unified-search' ) . '/';
	}

	public function determineSearchType( bool $isCorporateWiki ): string {
		if ( $isCorporateWiki ) {
			return self::SEARCH_TYPE_COMMUNITY;
		}

		return self::SEARCH_TYPE_PAGE;
	}

	public function pageSearch( UnifiedSearchPageRequest $request ): UnifiedSearchResult {
		$result = $this->callPageSearch( $request );

		$wikiUrls = $this->determineWikiUrls($request->isCrosswikiScope(), $result['results']);

		return new UnifiedSearchResult( $result['totalResultsFound'], $result['paging']['total'],
			$result['paging']['current'] + 1, array_map(function ($item) use ($wikiUrls) {
				$item['wikiUrl'] = $wikiUrls[$item['wikiId']] ?? null;
				return new UnifiedSearchPageResultItem($item);
			}, $result['results']) );
	}

	private function determineWikiUrls( bool $isCrosswiki, array $results): array {
		if ( !$isCrosswiki ) {
			return [];
		}

		$wikiIds = array_map(function ($item) {
			return $item['wikiId'];
		}, $results);

		$wikiIds = array_unique( $wikiIds );

		$wikiUrls = [];

		foreach ( $wikiIds as $wikiId ) {
			$wikiUrls[$wikiId] = WikiFactory::cityIDtoUrl( $wikiId );
		}

		return $wikiUrls;
	}

	private function callPageSearch( UnifiedSearchPageRequest $request ) {
		$params = [
			'lang' => $request->getLanguageCode(),
			'query' => $request->getQuery()->getSanitizedQuery(),
			'namespace' => $request->getNamespaces(),
			'page' => $request->getPage(),
			'limit' => $request->getLimit(),
		];

		if ($request->isInternalScope()) {
			$params['wikiId'] = $request->getWikiId();
		}

		if ( $request->isImageOnly() ) {
			$params['imageOnly'] = 'true';
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

	public function newsAndStoriesSearch( UnifiedSearchNewsAndStoriesRequest $request ): UnifiedSearchResult {
		$result = $this->callNewsAndStoriesSearch( $request );
		return new UnifiedSearchResult( $result['totalResultsFound'], $result['paging']['total'],
			$result['paging']['current'] + 1, array_map(function ($item) {
				return new UnifiedSearchNewsAndStoriesResultItem($item);
			}, $result['results']) );
	}

	private function callNewsAndStoriesSearch( UnifiedSearchNewsAndStoriesRequest $request ) {
		$params = [
			'query' => $request->getQuery()->getSanitizedQuery(),
			'page' => $request->getPage(),
			'limit' => $request->getLimit(),
		];

		$response = $this->doApiRequest( 'news-and-stories-search', $params );

		return json_decode( $response->getBody(), true );
	}

	public function communitySearch( UnifiedSearchCommunityRequest $request ): UnifiedSearchResult {
		$result = $this->callCommunitySearch( $request );

		return new UnifiedSearchResult( $result['totalResultsFound'], $result['paging']['total'],
			$result['paging']['current'] + 1, array_map(function ($item) {
				return new UnifiedSearchCommunityResultItem($item);
			}, $result['results']) );
	}

	private function callCommunitySearch( UnifiedSearchCommunityRequest $request ) {
		$params = [
			'query' => $request->getQuery()->getSanitizedQuery(),
			'page' => $request->getPage(),
			'limit' => $request->getLimit(),
			'lang' => $request->getLanguage(),
			'platform' => ['fandom', 'gamepedia']
		];

		$response = $this->doApiRequest( 'community-search', $params );

		return json_decode( $response->getBody(), true );
	}

}
