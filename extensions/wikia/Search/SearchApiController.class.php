<?php
/**
 * Class definition for SearchApiController
 */

use Wikia\Search\Config;
use Wikia\Search\QueryService\Factory;
use Wikia\Search\SearchResult;
use Wikia\Search\UnifiedSearch\UnifiedSearchRequest;
use Wikia\Search\UnifiedSearch\UnifiedSearchService;

/**
 * Controller to execute searches in the content of a wiki.
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 * @package Search
 * @subpackage Controller
 */
class SearchApiController extends WikiaApiController {

	const ITEMS_PER_BATCH = 25;
	const CROSS_WIKI_LIMIT = 25;
	const DEFAULT_SNIPPET_LENGTH = null;
	const ALL_LANGUAGES_STR = 'all';

	const PARAMETER_NAMESPACES = 'namespaces';
	const MIN_ARTICLE_QUALITY_PARAM_NAME = 'minArticleQuality';
	const DEFAULT_MIN_ARTICLE_QUALITY = 80;

	protected $allowedHubs = [ 'Gaming' => true, 'Entertainment' => true, 'Lifestyle' => true ];

	/**
	 * @var \WikiDetailsService|null
	 */
	private $wikiDetailService;

	/**
	 * Fetches results for the submitted query
	 *
	 * @requestParam string $query The query to use for the search
	 * @requestParam string $type [OPTIONAL] The search type, either articles (default) or videos
	 * @requestParam string $rank [OPTIONAL] The ranking to use in fetching the list of results, one of default,
	 *     newest, oldest, recently-modified, stable, most-viewed, freshest, stalest
	 * @requestParam integer $limit [OPTIONAL] The number of items per batch
	 * @requestParam integer $batch [OPTIONAL] The batch/page of results to fetch
	 * @requestParam string $namespaces [OPTIONAL] A comma-separated list of namespaces to restrict the results (e.g.
	 *     0, 14)
	 *
	 * @responseParam array $items The list of results
	 * @responseParam integer $total The total number of results
	 * @responseParam integer $currentBatch The index of the current batch/page
	 * @responseParam integer $batches The total number of batches/pages
	 * @responseParam integer $next The amount of items in the next batch/page
	 *
	 * @example &query=char
	 * @example &query=vid&type=videos
	 * @example &query=char&rank=oldest
	 * @example &limit=5&query=char
	 * @example &batch=2&limit=5&query=char
	 * @example &namespaces=14&query=char
	 */
	public function getList() {
		$config = $this->getConfigFromRequest();
		$service = new UnifiedSearchService();

		if ( $service->useUnifiedSearch( false ) ) {
			if ( !$config->getQuery()->hasTerms() ) {
				throw new InvalidParameterApiException( 'query' );
			}
			$request = new UnifiedSearchRequest( $config );
			$result = SearchResult::fromUnifiedSearchResult( $service->search( $request ) );
			if ( !$result->hasResults() ) {
				throw new NotFoundApiException();
			}
			$this->setUnifiedSearchResponse( $config, $result, WikiaResponse::CACHE_STANDARD );
		} else {
			$this->setResponseFromConfig( $config );
		}
	}

	/**
	 * Fetches results for cross-wiki search for submitted query
	 *
	 * @requestParam string $query The query to use for the search
	 * @requestParam string $lang The two chars wiki language code
	 * @requestParam string $rank [OPTIONAL] The ranking to use in fetching the list of results, one of default,
	 *     newest, oldest, recently-modified, stable, most-viewed, freshest, stalest
	 * @requestParam integer $batch [OPTIONAL] The batch/page of results to fetch
	 * @requestParam integer $limit [OPTIONAL] The number of wiki items per batch
	 * @requestParam integer $hideNonCommercialContent [OPTIONAL] hide content licensed on cc non commercial license
	 *
	 * @responseParam array $items The list of results
	 *
	 * @example &query=kermit&lang=en
	 * @example &query=kermit&lang=en&limit=10
	 * @example &query=kermit&lang=en&limit=2&batch=2
	 */
	public function getCrossWiki() {
		if ( !$this->request->getVal( 'query' ) ) {
			throw new InvalidParameterApiException( 'query' );
		}
		$expand = $this->request->getBool( 'expand', false );
		if ( $expand ) {
			$params = $this->getDetailsParams();
		}

		$responseValues =
			( new Factory )->getFromConfig( $this->getConfigCrossWiki() )->searchAsApi( [
				'id',
				'lang_s',
			], true );

		if ( empty( $responseValues['items'] ) ) {
			throw new NotFoundApiException();
		}

		$items = [];
		foreach ( $responseValues['items'] as $result ) {
			if ( $expand ) {
				$items[] =
					$this->getWikiDetailsService()
						->getWikiDetails( $result['id'], $params['imageWidth'],
							$params['imageHeight'], $params['length'] );
			} else {
				$items[] = [
					'id' => (int)$result['id'],
					'language' => $result['lang_s'],
				];
			}
		}
		$responseValues['items'] = $items;

		$this->setResponseData( $responseValues,
			[ 'urlFields' => [ 'url', 'wordmark', 'image' ] ] );
	}

	/**
	 * Sets the response based on values set in config
	 *
	 * @param Wikia\Search\Config $searchConfig
	 *
	 * @throws InvalidParameterApiException if query field in request is missing
	 * @throws NotFoundApiException
	 */
	protected function setResponseFromConfig( Config $searchConfig ) {
		if ( !$searchConfig->getQuery()->hasTerms() ) {
			throw new InvalidParameterApiException( 'query' );
		}

		//Standard Wikia API response with pagination values
		$responseValues = ( new Factory )->getFromConfig( $searchConfig )->searchAsApi( [
			'pageid' => 'id',
			'title',
			'url',
			'ns',
			'article_quality_i' => 'quality',
			'text' => 'snippet',
		], true );

		if ( empty( $responseValues['items'] ) ) {
			throw new NotFoundApiException();
		}

		$this->setResponseData( $responseValues, [ 'urlFields' => 'url' ],
			WikiaResponse::CACHE_STANDARD );
	}

	protected function setUnifiedSearchResponse(
		Config $config, SearchResult $result, $cacheValidity = 0
	) {
		$data = [
			'batches' => $result->getNumPages(),
			'currentBatch' => $result->getPage(),
			'next' => $result->getPage() * $config->getLimit() + 1,
			'total' => $result->getResultsFound(),
			'items' => $result->toArray( [
				'pageid' => 'id',
				'title',
				'url',
				'ns',
				'text' => 'snippet',
			] ),
		];

		$response = $this->getResponse();
		$response->setData( $data );
		if ( $cacheValidity > 0 ) {
			$response->setCacheValidity( $cacheValidity );
		}
	}

	/**
	 * Validates user-provided namespaces.
	 *
	 * @param Wikia\Search\Config $searchConfig
	 *
	 * @return Wikia\Search\Config
	 * @throws InvalidParameterApiException
	 */
	protected function validateNamespacesForConfig( Config $searchConfig ) {
		$namespaces = $this->getRequest()->getArray( 'namespaces', [] );
		if ( !empty( $namespaces ) ) {
			foreach ( $namespaces as &$n ) {
				if ( !is_numeric( $n ) ) {
					throw new InvalidParameterApiException( self::PARAMETER_NAMESPACES );
				}
			}

			$searchConfig->setNamespaces( $namespaces );
		}

		return $searchConfig;
	}

	/**
	 * Inspects request and sets config accordingly.
	 *
	 * @return Wikia\Search\Config
	 */
	protected function getConfigFromRequest() {
		$request = $this->getRequest();
		$searchConfig = new Config;
		$searchConfig->setQuery( $request->getVal( 'query', null ) )
			->setLimit( $request->getInt( 'limit', self::ITEMS_PER_BATCH ) )
			->setPage( $request->getVal( 'batch', 1 ) )
			->setRank( $request->getVal( 'rank', 'default' ) )
			->setMinArticleQuality( $request->getInt( self::MIN_ARTICLE_QUALITY_PARAM_NAME ) )
			->setVideoSearch( $request->getVal( 'type', 'articles' ) == 'videos' );

		return $this->validateNamespacesForConfig( $searchConfig );
	}

	/**
	 * Returns wikia Config for cross wiki search build on request data
	 *
	 * @return Wikia\Search\Config
	 */
	protected function getConfigCrossWiki() {
		$request = $this->getRequest();
		$searchConfig = new Config;
		$lang = $request->getArray( 'lang' );
		if ( in_array( self::ALL_LANGUAGES_STR, $lang ) ) {
			$lang = [ '*' ];
		}
		$searchConfig->setQuery( $request->getVal( 'query', null ) )
			->setLimit( $request->getInt( 'limit', static::CROSS_WIKI_LIMIT ) )
			->setPage( $request->getVal( 'batch', 1 ) )
			->setRank( $request->getVal( 'rank', 'default' ) )
			->setHub( $request->getArray( 'hub', null ) )
			->setInterWiki( true )
			->setCommercialUse( $this->hideNonCommercialContent() );
		if ( !empty( $lang ) ) {
			$searchConfig->setLanguageCode( $lang );
		}
		//this will set different boosting
		$searchConfig->setBoostGroup( 'CrossWikiApi' );

		return $searchConfig;
	}

	/**
	 * @return \WikiDetailsService
	 */
	protected function getWikiDetailsService() {
		if ( !isset( $this->wikiDetailService ) ) {
			$this->wikiDetailService = new WikiDetailsService();
		}

		return $this->wikiDetailService;
	}

	protected function getDetailsParams() {
		return [
			'imageWidth' => $this->request->getVal( 'width', null ),
			'imageHeight' => $this->request->getVal( 'height', null ),
			'length' => $this->request->getVal( 'snippet', static::DEFAULT_SNIPPET_LENGTH ),
		];
	}
}
