<?php
/**
 * Class definition for SearchApiController
 */
use Wikia\Search\Config, Wikia\Search\QueryService\Factory, Wikia\Search\QueryService\DependencyContainer;
/**
 * Controller to execute searches in the content of a wiki.
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 * @package Search
 * @subpackage Controller
 */
class SearchApiController extends WikiaApiController {
	const ITEMS_PER_BATCH = 25;
	const CROSS_WIKI_LIMIT = 25;

	const PARAMETER_NAMESPACES = 'namespaces';

	/**
	 * Fetches results for the submitted query
	 *
	 * @requestParam string $query The query to use for the search
	 * @requestParam string $type [OPTIONAL] The search type, either articles (default) or videos
	 * @requestParam string $rank [OPTIONAL] The ranking to use in fetching the list of results, one of default, newest, oldest, recently-modified, stable, most-viewed, freshest, stalest
	 * @requestParam integer $limit [OPTIONAL] The number of items per batch
	 * @requestParam integer $batch [OPTIONAL] The batch/page of results to fetch
	 * @requestParam string $namespaces [OPTIONAL] A comma-separated list of namespaces to restrict the results (e.g. 0, 14)
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
		$this->setResponseFromConfig( $this->getConfigFromRequest() );
	}

	/**
	 * Fetches results for cross-wiki search for submitted query
	 *
	 * @requestParam string $query The query to use for the search
	 * @requestParam string $lang The two chars wiki language code
	 * @requestParam string $rank [OPTIONAL] The ranking to use in fetching the list of results, one of default, newest, oldest, recently-modified, stable, most-viewed, freshest, stalest
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
		if ( !$this->request->getVal( 'lang' ) ) {
			throw new InvalidParameterApiException( 'lang' );
		}

		$resultSet = (new Factory)->getFromConfig( $this->getConfigCrossWiki() )->search();
		$items = array();
		foreach( $resultSet->getResults() as $result ) {
			$items[] = array(
				'id' => (int) $result['id'],
				'language' => $result['lang_s'],
			);
		}

		$this->response->setVal( 'items', $items );
	}

	/**
	 * Sets the response based on values set in config
	 * @param Wikia\Search\Config $searchConfig
	 * @param array $fields that will be returned in items array
	 * @param bool $metadata if true, will return also query statistics
	 * @throws InvalidParameterApiException if query field in request is missing
	 */
	protected function setResponseFromConfig( Wikia\Search\Config $searchConfig ) {
		if (! $searchConfig->getQuery()->hasTerms() ) {
			throw new InvalidParameterApiException( 'query' );
		}

		//Standard Wikia API response with pagination values
		$responseValues = (new Factory)->getFromConfig( $searchConfig )->searchAsApi( ['pageid' => 'id', 'title', 'url', 'ns' ], true );

		if ( empty( $responseValues['items'] ) ) {
			throw new NotFoundApiException();
		}

		$response = $this->getResponse();
		$response->setValues( $responseValues );

		$response->setCacheValidity(
			86400 /* 24h */,
			86400 /* 24h */,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);
	}
	
	/**
	 * Validates user-provided namespaces.
	 * @param Wikia\Search\Config $searchConfig
	 * @throws InvalidParameterApiException
	 * @return Wikia\Search\Config
	 */
	protected function validateNamespacesForConfig( $searchConfig ) {
		$namespaces = $this->getRequest()->getArray( 'namespaces', [] );
		if (! empty( $namespaces ) ) {
			foreach ( $namespaces as &$n ) {
				if (! is_numeric( $n ) ) {
					throw new InvalidParameterApiException( self::PARAMETER_NAMESPACES );
				}
			}
			
			$searchConfig->setNamespaces( $namespaces );
		}
		return $searchConfig;
	}
	
	/**
	 * Inspects request and sets config accordingly.
	 * @return Wikia\Search\Config
	 */
	protected function getConfigFromRequest() {
		$request = $this->getRequest();
		$searchConfig = new Wikia\Search\Config;
		$searchConfig->setQuery( $request->getVal( 'query', null ) )
		             ->setLimit( $request->getInt( 'limit', self::ITEMS_PER_BATCH ) )
		             ->setPage( $request->getVal( 'batch', 1 ) )
		             ->setRank( $request->getVal( 'rank', 'default' ) )
		             ->setVideoSearch( $request->getVal( 'type', 'articles' ) == 'videos' )
		;
		return $this->validateNamespacesForConfig( $searchConfig );
	}

	/**
	 * Returns wikia Config for cross wiki search build on request data
	 * @return Wikia\Search\Config
	 */
	protected function getConfigCrossWiki() {
		$request = $this->getRequest();
		$searchConfig = new Wikia\Search\Config;
		$searchConfig->setQuery( $request->getVal( 'query', null ) )
			->setLimit( $request->getInt( 'limit', static::CROSS_WIKI_LIMIT ) )
			->setPage( $request->getVal( 'batch', 1 ) )
			->setRank( $request->getVal( 'rank', 'default' ) )
			->setInterWiki( true )
			->setCommercialUse( $this->hideNonCommercialContent() )
			->setLanguageCode( $request->getVal( 'lang' ) )
		;
		return $searchConfig;
	}
}
