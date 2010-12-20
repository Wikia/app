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
		wfProfileIn( __METHOD__ );
		
		//if ( $request->wasPosted() ) {
			wfLoadExtensionMessages( 'MobileApp' );
			$ret = Array();
			
			//-----//
			$term = $this->getRequest()->getText( 'term' );
			
			$search = SearchEngine::create();
			$search->setLimitOffset( self::RESULTS_LIMIT );
			$search->setNamespaces( SearchEngine::searchableNamespaces() );
			$search->showRedirects = true;
			//$search->prefix = $this->mPrefix;
			$term = $search->transformSearchTerm($term);
			
			$rewritten = $search->replacePrefixes($term);
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
							
							if( $titleMatches ) {
								if( $titleMatches->numRows() ) {
									global $wgContLang;
									$terms = $wgContLang->convertForSearchResult(
										$titleMatches->termMatches()
									);
									
									$ret[ 'titleMatchesInfo' ] = $titleMatches->getInfo();
									$ret[ 'titleMatches' ] = Array();
									
									while( $result = $titleMatches->next() ) {
										$ret[ 'titleMatches' ][] = Array(
											'link' => $this->showHit( $result),
											'terms' => $terms
										);
									}
								}
								
								$titleMatches->free();
							}
					
							if( $textMatches ) {
								if( $textMatches->numRows() ) {
									global $wgContLang;
									$terms = $wgContLang->convertForSearchResult(
										$textMatches->termMatches()
									);
									
									$ret[ 'textMatchesInfo' ] = $textMatches->getInfo();
									$ret[ 'textMatches' ] = Array();
									
									while( $result = $textMatches->next() ) {
										$ret[ 'textMatches' ][] = Array(
											'link' => $this->showHit( $result),
											'terms' => $terms
										);
									}
								}
								
								$textMatches->free();
							}
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
			//-----//
			
			$this->setResponseContentType( 'application/json; charset=utf-8' );
			$this->setResponseContent( Wikia::json_encode( $ret ) );
		//}
		
		wfProfileOut( __METHOD__ );
	}
	
	private function showHit( $result ) {
		global $wgContLang, $wgLang, $wgUser;
		wfProfileIn( __METHOD__ );

		if( $result->isBrokenTitle() ) {
			return "Broken link";
		}

		$sk = $wgUser->getSkin();
		$title = $result->getTitle();

		// If the page doesn't *exist*... our search index is out of date.
		// The least confusing at this point is to drop the result.
		// You may get less results, but... oh well. :P
		if( $result->isMissingRevision() ) {
			wfProfileOut( __METHOD__ );
			return "Missing page";
		}
		
		wfProfileOut( __METHOD__ );
		return $title->getFullURL();
	}
}