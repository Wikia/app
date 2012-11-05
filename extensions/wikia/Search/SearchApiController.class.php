<?php
/**
 * Controller to execute searches in the content of a wiki.
 *
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */

class SearchApiController extends WikiaApiController {
	const ITEMS_PER_BATCH = 25;

	/**
	 * Fetches results for the submitted query
	 *
	 * @requestParam string $query The query to use for the search
	 * @requestParam string $type [OPTIONAL] The search type, either articles (default) or videos
	 * @requestParam string $rank [OPTIONAL] The ranking to use in fetching the list of results, one of default, newest, oldest, recently-modified, stable, most-viewed, freshest, stalest
	 * @requestParam integer $limit [OPTIONAL] The number of items per batch
	 * @requestParam integer $batch [OPTIONAL] The batch/page of results to fetch
	 * @requestParam string $namespaces [OPTIONAL] A comma-separated list of namespaces to restrict the results (e.g. main, user)
	 *
	 * @responseParam array $items The list of results
	 * @responseParam integer $total The total number of results
	 * @responseParam integer $currentBatch The index of the current batch/page
	 * @responseParam integer $batches The total number of batches/pages
	 * @responseParam integer $next The amount of items in the next batch/page
	 */
	public function getList() {
		$searchConfig = F::build('WikiaSearchConfig');
		$type = $this->request->getVal( 'type', 'articles' );
		$query = $this->getVal( 'query', null );
		$rank = $this->request->getVal( 'rank', 'default' );
		$limit = $this->request->getInt( 'limit', self::ITEMS_PER_BATCH );
		$batch = $this->request->getVal( 'batch', 1 );
		$namespaces = $this->request->getVal( 'namespaces', null );
		$total = 0;
		$results = array();
		$batches = 0;
		$currentBatch = 0;
		$next = 0;

		$searchConfig->setQuery( $query )
			->setCityId( $this->wg->CityId )
			->setLimit( $limit )
			->setPage( $batch )
			->setRank( $rank )
			->setDebug( false )
			->setSkipCache( false )
			->setAdvanced( false )
			->setHub( false )
			->setRedirs( false )
			->setIsInterWiki( false )
			->setVideoSearch( $type == 'videos' )
			->setGroupResults( false );

		if ( !empty( $namespaces ) ) {
			$namespaces = explode( ',', $namespaces );

			foreach( $namespaces as $index => $key ) {
				$nsId = ( strtolower( $key ) == 'main' ) ? 0 : $this->wg->ContLang->getNsIndex( $key );

				if ( $nsId !== false ) {
					$namespaces[$index] = $nsId;
				} else {
					unset( $namespaces[$index] );
				}
			}

			if ( !empty( $namespaces ) ) {
				$searchConfig->setNamespaces( $namespaces );
			}
		}

		if ( $searchConfig->getQueryNoQuotes( true ) ) {
			$resultSet = F::build( 'WikiaSearch' )->doSearch( $searchConfig );
			$total = $searchConfig->getResultsFound();

			if ( $total ) {
				foreach ( $resultSet as $result ) {
					$results[] = array(
						'title' => $result->getTitle(),
						'url' => $result->getTitleObject()->getLocalUrl()
					);
				}

				$total = $searchConfig->getResultsFound();
				$batches = $searchConfig->getNumPages();
				$currentBatch = $searchConfig->getPage();
				$next = ( $total - ( $limit * $currentBatch ) );

				if ($next > $limit) {
					$next = $limit;
				}
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