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
		$searchConfig = new Config();
		$type = $this->request->getVal( 'type', 'articles' );
		$query = $this->getVal( 'query', null );
		$rank = $this->request->getVal( 'rank', 'default' );
		$limit = $this->request->getInt( 'limit', self::ITEMS_PER_BATCH );
		$batch = $this->request->getVal( 'batch', 1 );
		$namespaces = $this->request->getArray( 'namespaces', null );
		$total = 0;
		$results = [];
		$batches = 0;
		$currentBatch = 0;
		$next = 0;

		$searchConfig->setQuery( $query )
		             ->setLimit( $limit )
		             ->setPage( $batch )
		             ->setRank( $rank )
		             ->setVideoSearch( $type == 'videos' )
		;

		if ( !empty( $namespaces ) ) {
			foreach ( $namespaces as &$n ) {
				if ( is_numeric( $n ) ) {
					$n = (int) $n;
				} else {
					throw new InvalidParameterApiException( self::PARAMETER_NAMESPACES );
				}
			}

			$searchConfig->setNamespaces( $namespaces );
		}

		if ( $searchConfig->getQuery()->hasTerms() ) {
			$wikiaSearch = (new Factory)->getFromConfig( $searchConfig );

			$resultSet = $wikiaSearch->search( $searchConfig );
			$total = $searchConfig->getResultsFound();

			if ( $total ) {
				$results = $resultSet->toArray( ['pageid' => 'id', 'title', 'url', 'ns' ] );
				unset( $results['pageid'] );

				$batches = $searchConfig->getNumPages();
				$currentBatch = $searchConfig->getPage();
				$next = max( 0, $total - ( $limit * $currentBatch ) );

				if ( $next > $limit ) {
					$next = $limit;
				}
			} else {
				throw new NotFoundApiException();
			}
		}

		//Standard Wikia API response with pagination values
		$this->response->setVal( 'items',	$results );
		$this->response->setVal( 'next', $next );
		$this->response->setVal( 'total', $total );
		$this->response->setVal( 'batches', $batches );
		$this->response->setVal( 'currentBatch', $currentBatch );

		$this->response->setCacheValidity(
			86400 /* 24h */,
			86400 /* 24h */,
			array(
				WikiaResponse::CACHE_TARGET_BROWSER,
				WikiaResponse::CACHE_TARGET_VARNISH
			)
		);
	}
}