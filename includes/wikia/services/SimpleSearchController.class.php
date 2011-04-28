<?php

class SimpleSearchController extends WikiaController {
	private $mEnableCrossWikiaSearch;
	private $mDisableTextSearch;
	
	public function init() {
		list(
			$this->mEnableCrossWikiaSearch,
			$this->mDisableTextSearch
		) = $this->getApp()->getGlobals(
			'wgEnableCrossWikiaSearch',
			'wgDisableTextSearch'
		);
	}
	
	private function getResults() {
		$this->getApp()->profileIn( __METHOD__ );
		
		//parameters
		$key = trim( $this->getRequest()->getVal( 'key' ) );
		$limit = $this->getRequest()->getInt( 'limit', 0 );
		$offset = $this->getRequest()->getInt( 'offset', 0 );
		$namespaces = (array) $this->getRequest()->getVal( 'namespaces', array() );
		$showRedirects = $this->getRequest()->getBool( 'redirects', true );
		
		$results = Array();
		$this->getResponse()->setVal( 'key', $key );
		
		if ( !empty( $key ) ) {
			$search = SearchEngine::create();
			$search->setLimitOffset( $limit, $offset );
			
			$namespaces = array_merge( $search->namespaces, $namespaces );
			$search->setNamespaces( $namespaces );
			
			$search->showRedirects = $showRedirects;
			
			$key = $search->transformSearchTerm( $key );
			$rewritten = $search->replacePrefixes( $key );
			$titleMatches = $search->searchTitle( $rewritten );
			$textMatches = $search->searchText( $rewritten );
			$totalCount = 0;
			
			if ( !( ( $search instanceof SearchErrorReporting ) && $search->getError() ) ) {
				if ( empty( $this->mDisableTextSearch ) ) {
					// Sometimes the search engine knows there are too many hits
					if ( !( $titleMatches instanceof SearchResultTooMany ) ) {
						//count number of results
						$num = ( $titleMatches ? $titleMatches->numRows() : 0 ) +
							( $textMatches ? $textMatches->numRows() : 0);
						
						//MW hooks
						if( $num ) {
							$this->getApp()->runHook( 'SpecialSearchResults', array( $key, &$titleMatches, &$textMatches ) );
						} else {
							$this->getApp()->runHook( 'SpecialSearchNoResults', array( $key ) );
						}
						
						$this->getResponse()->setVal( 'count', $num );
						
						if ( $titleMatches && !is_null( $titleMatches->getTotalHits() ) ) {
							$totalCount += $titleMatches->getTotalHits();
						}
						
						if ( $textMatches && !is_null( $textMatches->getTotalHits() ) ) {
							$totalCount += $textMatches->getTotalHits();
						}
						
						$this->getResponse()->setVal( 'totalCount', $totalCount );
						
						// did you mean... suggestions
						if ($textMatches && $textMatches->hasSuggestion() ) {
							$this->getResponse( 'suggestionQuery', $textMatches->getSuggestionQuery() );
							$this->getResponse( 'suggestionSnippet', $textMatches->getSuggestionSnippet() );
						}
						
						foreach ( array( 'title', 'text' ) as $set ) {
							$resultSetVar = "{$set}Matches";
							$matches = $$resultSetVar;
							
							if ( $matches ) {
								if ( $matches->numRows() ) {
									$this->getResponse()->setVal( "{$set}ResultsInfo", $matches->getInfo() );
									$results = array();
									
									while ( $result = $matches->next() ) {
										if ( !$result->isBrokenTitle() && !$result->isMissingRevision() ) {
											$title = $result->getTitle();
											
											$results[] = array(
												'textForm' => $title->getText(),
												'urlForm' => $title->getFullUrl()
											);
										}
									}
									
									$this->getResponse()->setVal( "{$set}Results", $results );
								}
								
								$matches->free();
							}
						}
						
						
					} else {
						$this->getApp()->profileOut( __METHOD__ );
						throw new SimpleSearchTooManyResultsException();
					}
				} else {
					$this->getApp()->profileOut( __METHOD__ );
					throw new SimpleSearchDisabledException();
				}
			} else {
				$this->getApp()->profileOut( __METHOD__ );
				throw new SimpleSearchEngineException( $search );
			}
		} else {
			$this->getApp()->profileOut( __METHOD__ );
			throw new SimpleSearchEmptyKeyException();
		}
		
		$this->getResponse()->setVal( 'results', $results );
		
		$this->getApp()->profileOut( __METHOD__ );
	}
	
	public function localSearch() {
		$this->getApp()->setGlobal( 'wgEnableCrossWikiaSearch', false );
		$this->getResults();
		$this->getApp()->setGlobal( 'wgEnableCrossWikiaSearch', $this->mEnableCrossWikiaSearch );
	}
	
	public function globalSearch() {
		$this->getApp()->setGlobal( 'wgEnableCrossWikiaSearch', true );
		$this->getResults();
		$this->getApp()->setGlobal( 'wgEnableCrossWikiaSearch', $this->mEnableCrossWikiaSearch );
	}
}