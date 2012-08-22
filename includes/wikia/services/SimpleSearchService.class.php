<?php
/**
 * Simplified API for local and wikia-wide (global) search
 *
 * @author Federico "Lox" Lucignano
 * @deprecated
 * @see WikiaSearch
 */
class SimpleSearchService extends WikiaService {
	const DEFAULT_LIMIT = 100;

	private $mEnableCrossWikiaSearch;

	public function init() {
		$this->mEnableCrossWikiaSearch = $this->wg->EnableCrossWikiaSearch;
	}

	/*
	 * @todo separate the data fetching code in a model
	 */
	private function getResults() {
		$this->wf->profileIn( __METHOD__ );

		//parameters
		$key = trim( $this->getVal( 'key' ) );
		$limit = $this->request->getInt( 'limit', self::DEFAULT_LIMIT );
		$offset = $this->request->getInt( 'offset', 0 );
		$namespaces = (array) $this->getVal( 'namespaces', array() );
		$showRedirects = $this->request->getBool( 'redirects', true );
		$urlParams = $this->getVal( 'urlParams', '' );
		$fullURL = $this->request->getBool( 'fullURL', false );

		$results = Array();
		$this->setVal( 'key', $key );

		if ( !empty( $key ) ) {
			$search = F::build( 'SearchEngine', array(), 'create' );

			if ( $limit > 0 ) {
				$search->setLimitOffset( $limit, $offset );
			}

			$namespaces = array_merge( $search->namespaces, $namespaces );
			$search->setNamespaces( $namespaces );

			$search->showRedirects = $showRedirects;

			$key = $search->transformSearchTerm( $key );
			$rewritten = $search->replacePrefixes( $key );
			$titleMatches = $search->searchTitle( $rewritten );
			$textMatches = $search->searchText( $rewritten );
			$totalCount = 0;

			if ( !( ( $search instanceof SearchErrorReporting ) && $search->getError() ) ) {
				if ( empty( $this->wg->DisableTextSearch ) ) {
					// Sometimes the search engine knows there are too many hits
					if ( !( $titleMatches instanceof SearchResultTooMany ) ) {
						//count number of results
						$num = ( $titleMatches ? $titleMatches->numRows() : 0 ) +
							( $textMatches ? $textMatches->numRows() : 0);

						//MW hooks
						if( $num ) {
							$this->app->runHook( 'SpecialSearchResults', array( $key, &$titleMatches, &$textMatches ) );
						} else {
							$this->app->runHook( 'SpecialSearchNoResults', array( $key ) );
						}

						$this->setVal( 'count', $num );

						if ( $titleMatches && !is_null( $titleMatches->getTotalHits() ) ) {
							$totalCount += $titleMatches->getTotalHits();
						}

						if ( $textMatches && !is_null( $textMatches->getTotalHits() ) ) {
							$totalCount += $textMatches->getTotalHits();
						}

						$this->setVal( 'totalCount', $totalCount );

						// did you mean... suggestions
						if ($textMatches && $textMatches->hasSuggestion() ) {
							$this->setVal( 'suggestionQuery', $textMatches->getSuggestionQuery() );
							$this->setVal( 'suggestionSnippet', $textMatches->getSuggestionSnippet() );
						}

						foreach ( array( 'title', 'text' ) as $set ) {
							$resultSetVar = "{$set}Matches";
							$matches = $$resultSetVar;

							if ( $matches ) {
								if ( $matches->numRows() ) {
									$this->setVal( "{$set}ResultsInfo", $matches->getInfo() );
									$results = array();

									while ( $result = $matches->next() ) {
										if ( !$result->isBrokenTitle() && !$result->isMissingRevision() ) {
											$title = $result->getTitle();

											$results[] = array(
												'textForm' => $title->getText(),
												'urlForm' => ( $fullURL ) ? $title->getFullUrl( $urlParams ) : $title->getLocalUrl( $urlParams )
											);
										}
									}

									$this->setVal( "{$set}Results", $results );
								}

								$matches->free();
							}
						}
					} else {
						$this->wf->profileOut( __METHOD__ );
						throw new SimpleSearchTooManyResultsException();
					}
				} else {
					$this->wf->profileOut( __METHOD__ );
					throw new SimpleSearchDisabledException();
				}
			} else {
				$this->wf->profileOut( __METHOD__ );
				throw new SimpleSearchEngineException( $search );
			}
		} else {
			$this->wf->profileOut( __METHOD__ );
			throw new SimpleSearchEmptyKeyException();
		}

		$this->setVal( 'results', $results );

		$this->wf->profileOut( __METHOD__ );
	}

	/**
	 * @brief Runs a local search on the current wiki
	 *
	 * @todo Finish documenting
	 * @see getResults
	 */
	public function localSearch() {
		$this->wg->EnableCrossWikiaSearch = false;
		$this->getResults();
		$this->wg->EnableCrossWikiaSearch = $this->mEnableCrossWikiaSearch;
	}

	/**
	 * @brief Runs a wikia-wide (global) search
	 *
	 * @todo Finish documenting
	 * @see getResults
	 */
	public function globalSearch() {
		$this->wg->EnableCrossWikiaSearch = true;
		$this->request->setVal( 'fullURL', true );
		$this->getResults();
		$this->wg->EnableCrossWikiaSearch = $this->mEnableCrossWikiaSearch;
	}
}

class SimpleSearchTooManyResultsException extends WikiaException {
	function __construct() {
		parent::__construct( 'Too many results' );
	}
}

class SimpleSearchDisabledException extends WikiaException {
	function __construct() {
		parent::__construct( 'Search disabled' );
	}
}

class SimpleSearchEngineException extends WikiaException {
	function __construct( SearchEngine $search ) {
		parent::__construct( "Search error: {$search->getError()}" );
	}
}

class SimpleSearchEmptyKeyException extends WikiaException {
	function __construct() {
		parent::__construct( 'Empty key' );
	}
}
