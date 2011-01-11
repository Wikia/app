<?php
/**
 * MobileApiSearch module
 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
 */
class MobileApiSearch extends MobileApiBase {
	const RESULTS_LIMIT = 50;
	/*
	 * Searches for a term wikia-wide
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	public function getGlobalResults(){
		global $wgDevelEnvironment;
		wfProfileIn( __METHOD__ );
		
		//This needs to be true but setting it in WF will make it happen in Special:Search too
		//Probably not wanted if this is not going to be enabled on communitycentral
		global $wgEnableCrossWikiaSearch;
		$origEnableCrossWikiaSearchValue = $wgEnableCrossWikiaSearch;
		$wgEnableCrossWikiaSearch = true;
		
		//get requests are allowed only when running on test environment
		if ( $request->wasPosted() || $wgDevelEnvironment ) {
			wfLoadExtensionMessages( 'MobileApp' );
			$ret = Array();
			
			//TODO: handle empty search term
			$term = $this->getRequest()->getText( 'term' );
			
			$search = SearchEngine::create();
			$search->setLimitOffset( self::RESULTS_LIMIT );
			$search->setNamespaces( SearchEngine::searchableNamespaces() );
			$search->showRedirects = true;
			
			$term = $search->transformSearchTerm( $term );
			$rewritten = $search->replacePrefixes( $term );
			$titleMatches = $search->searchTitle( $rewritten );
			$textMatches = $search->searchText( $rewritten );
			
			if ( !( ( $search instanceof SearchErrorReporting ) && $search->getError() ) ) {
				// did you mean... suggestions
				if ( $textMatches && $textMatches->hasSuggestion() ) {
					$ret[ 'didYouMeanQuery' ] = $textMatches->getSuggestionQuery();
					$ret[ 'didYouMeanSnippet' ] = $textMatches->getSuggestionSnippet();
				}
				
				if ( trim( $term ) !== '' ) {
					global $wgDisableTextSearch;
					
					if ( empty( $wgDisableTextSearch ) ) {
						//count number of results
						$num = ( $titleMatches ? $titleMatches->numRows() : 0 ) +
							( $textMatches ? $textMatches->numRows() : 0);
						$totalNum = 0;
						
						if ( $titleMatches && !is_null( $titleMatches->getTotalHits() ) ) {
							$totalNum += $titleMatches->getTotalHits();
						}
						
						if ( $textMatches && !is_null( $textMatches->getTotalHits() ) ) {
							$totalNum += $textMatches->getTotalHits();
						}
				
						// Sometimes the search engine knows there are too many hits
						if ( !( $titleMatches instanceof SearchResultTooMany ) ) {
							// show number of results
							$ret[ 'resultsCount' ] = $num;
							$ret[ 'resultsTotalCount' ] = $totalNum;
							
							//MW hooks
							if( $num ) {
								wfRunHooks(
									'SpecialSearchResults',
									array( $term, &$titleMatches, &$textMatches )
								);
							} else {
								wfRunHooks( 'SpecialSearchNoResults', array( $term ) );
							}
							
							$this->processMatches( $titleMatches, 'title', $ret );
							$this->processMatches( $textMatches, 'text', $ret );
						} else {
							$ret = Array( 'error' => 'too many results' );
						}
					} else {
						$ret = Array('error' => 'search disabled');
					}
				} else {
					$ret = Array('error' => 'empty search term');
				}
			} else {
				$ret = Array(
					'error' => $search->getError(),
					'tracker' => $search->getErrorTracker()
				);
			}
			
			$this->setResponseContentType( 'application/json; charset=utf-8' );
			$this->setResponseContent( Wikia::json_encode( $ret ) );
		}
		
		$wgEnableCrossWikiaSearch = $origEnableCrossWikiaSearchValue;
		wfProfileOut( __METHOD__ );
	}
	
	private function showHit( $result ) {
		global $wgContLang, $wgLang, $wgUser;
		wfProfileIn( __METHOD__ );

		if( $result->isBrokenTitle() ) {
			return "Broken link";
		}
		
		// If the page doesn't *exist*... our search index is out of date.
		// The least confusing at this point is to drop the result.
		// You may get less results, but... oh well. :P
		if( $result->isMissingRevision() ) {
			wfProfileOut( __METHOD__ );
			return "Missing page";
		}
		
		wfProfileOut( __METHOD__ );
		//TODO: return more data, like the article readable title, perhaps an article snippet via ArticleService and the wiki name
		return $result->getUrl();
	}
	
	private function processMatches( $matches, $type, &$output ) {
		if( $matches ) {
			if( $matches->numRows() ) {
				global $wgContLang;
				$terms = $wgContLang->convertForSearchResult(
					$matches->termMatches()
				);
				
				$output[ "{$type}MatchesInfo" ] = $matches->getInfo();
				$output[ "{$type}Matches" ] = Array();
				
				while( $result = $matches->next() ) {
					$output[ "{$type}Matches" ][] = Array(
						'link' => $this->showHit( $result),
						'terms' => $terms
					);
				}
			}
			
			$matches->free();
		}
	}
}