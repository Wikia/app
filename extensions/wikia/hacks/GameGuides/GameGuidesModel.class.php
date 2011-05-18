<?php
/**
 * A model for the Game Guides controller
 * @author Federico "Lox" Lucignano
 */

class GameGuidesModel{
	/**
	 * the WikiFactory toggle that qualifies a wiki for being listed in the app
	 */
	const WF_WIKI_RECOMMEND_VAR = 'wgWikiaGameGuidesRecommend';
	const MEMCHACHE_KEY_PREFIX = 'WikiaGameGuides';
	const CACHE_DURATION = 86400;//24h
	const SEARCH_RESULTS_LIMIT = 100;
	const CATEGORY_RESULTS_LIMIT = 0;//no limits for now
	
	private $app;
	
	function __construct(){
		$this->app = F::app();
	}
	
	/*
	 * Gets a list of recommended wikis through WikiFactory
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	public function getWikisList( $limit = null, $offset = 0 ){
		$this->app->wf->profileIn( __METHOD__ );
		$cacheKey = $this->generateCacheKey( __METHOD__ );
		$games = $this->loadFromCache( $cacheKey );
		$ret = Array();
		
		if ( empty( $games ) ) {
			$games = Array();
			$wikiFactoryRecommendVar = WikiFactory::getVarByName( self::WF_WIKI_RECOMMEND_VAR, null );
			
			if ( !empty( $wikiFactoryRecommendVar ) ) {
				$recommendedIds = WikiFactory::getCityIDsFromVarValue( $wikiFactoryRecommendVar->cv_variable_id, true, '=' );
				
				foreach( $recommendedIds as $wikiId ) {
					$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
					//$wikiGames = WikiFactory::getVarValueByName( 'wgWikiTopics', $wikiId );
					$wikiDomain = str_replace('http://', '', WikiFactory::getVarValueByName( 'wgServer', $wikiId ));
					$wikiThemeSettings = WikiFactory::getVarValueByName( 'wgOasisThemeSettings', $wikiId);
					//$wikiLogo = WikiFactory::getVarValueByName( "wgLogo", $wikiId );
					
					$games[] = Array(
						'name' => ( !empty( $wikiThemeSettings[ 'wordmark-text' ] ) ) ? $wikiThemeSettings[ 'wordmark-text' ] : $wikiName,
						//'wikiGames' => ( !empty( $wikiGames ) ) ? $wikiGames : '',
						'color' => ( !empty( $wikiThemeSettings[ 'wordmark-color' ] ) ) ? $wikiThemeSettings[ 'wordmark-color' ] : '#0049C6',
						'backgroundColor' => ( !empty( $wikiThemeSettings[ 'color-page' ] ) ) ? $wikiThemeSettings[ 'color-page' ] : '#FFFFFF',
						'domain' => $wikiDomain,
						'wordmarkUrl'=> ( !empty( $wikiThemeSettings[ 'wordmark-image-url' ] ) ) ? $wikiThemeSettings[ 'wordmark-image-url' ] : null
					);
				}
			} else {
				$this->app->wf->profileOut( __METHOD__ );
				throw new WikiaException( 'WikiFactory variable \'' . self::WF_WIKI_RECOMMEND_VAR . '\' not found' );
			}
			
			$this->storeInCache( $cacheKey , $games );
		}
		
		if ( !empty( $limit ) ) {
			$ret['items'] = array_slice( $games, $offset, $limit );
			$ret['next'] = ( ( $offset + $limit ) < count( $games ) ) ? $offset + count( $ret['items'] ) : false;
		} else {
			$ret['items'] = $games;
		}
		
		$this->app->wf->profileOut( __METHOD__ );
		return $ret;
	}
	
	/*
	 * Returns a structure representing application-related content for the current wiki
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	public function getWikiContents($limit = null){
		wfProfileIn( __METHOD__ );
		$cacheKey = $this->generateCacheKey( __METHOD__ . ":limit-{$limit}" );
		$ret = $this->loadFromCache( $cacheKey );
		
		if ( empty( $ret ) ) {
			$ret = Array();
			wfLoadExtensionMessages( 'WikiaGameGuides' );
			
			$searchTitle = Title::newFromText( 'Search', NS_SPECIAL );
			$ret[ 'searchURL' ] = $searchTitle->getLocalUrl( array( 'useskin' => 'wikiaapp' ) );
			
			$ret[ 'entries' ] = Array();
			
			$entries = array_filter(
				explode( "\n", strip_tags( str_replace( array( '<br>', '<br/>', '<br />' ), "\n" , wfMsgForContent( 'wikiagameguides-contents' ) ) ) ),
				array( __CLASS__, 'verifyElement')
			);
			
			foreach ( $entries as $entry ) {
				$info = explode( '|', $entry);
				array_walk( $info, 'trim' );
				
				$ret[ 'entries' ][] = array(
					'title' => $info[ 0 ],
					'categoryName' => $info[ 1 ],
					'icon' => ( !empty( $info[ 2 ] ) ) ? $info[ 2 ] : null
				);
			}
			
			$this->storeInCache($cacheKey , $ret);
		}
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}
	
	/*
	 * Gets data for a Wiki's entry
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	public function getCategoryContents( $categoryName, $limit = self::CATEGORY_RESULTS_LIMIT ) {
		wfProfileIn( __METHOD__ );
		$categoryName = trim( $categoryName );
		$category = Category::newFromName( $categoryName );
		
		if ( $category ) {
			$cacheKey = $this->generateCacheKey(
				__METHOD__ .
				":category-{$category->getID()}" .
				":limit-{$limit}"
			);
			$ret = $this->loadFromCache( $cacheKey );
			
			if ( empty( $ret ) ) {
				$ret = Array();
				$titles = $category->getMembers($limit);
				
				foreach( $titles as $title ) {
					$ret[] = Array(
						'title' => $title->getText(),
						//TODO: replace temporary solution to reach the App skin
						'url' => $title->getLocalUrl( array( 'useskin' => 'wikiaapp' ) )
					);
				}
			}
			
			$this->storeInCache($cacheKey , $ret);
		} else {
			wfProfileOut( __METHOD__ );
			throw new EzApiException( "No data for '{$categoryName}'" );
		}
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}
	
	
	/*
	 * Searches for a term wikia-wide
	 * 
	 * @author Federico "Lox" Lucignano <federico@wikia-inc.com>
	 */
	public function getLocalSearchResults($term, $limit = self::SEARCH_RESULTS_LIMIT){
		wfProfileIn( __METHOD__ );
		
		/*
		die(var_dump(F::app()->sendRequest( 'SimpleSearch', 'localSearch', array( 'key' => $term, 'limit' => $limit ) )->getVal('textResults')));
		exit;
		*/
		
		global $wgEnableCrossWikiaSearch, $wgDisableTextSearch;
		$term = trim( $term );
		$ret = Array();
		
		if ( !empty( $term ) ) {
			wfLoadExtensionMessages( 'WikiaGameGuides' );
			$cacheKey = $this->generateCacheKey(
				__METHOD__ .
				':term-' .
				str_replace( ' ',  '_', $term ) ./* no spaces in memcache keys */
				":limit-{$limit}"
			);
			$ret = $this->loadFromCache( $cacheKey );
			
			if ( empty( $ret ) ) {
				//This is set in WF, in this case we want only local results
				$wgEnableCrossWikiaSearch = false;
				$ret = Array();
				
				$search = SearchEngine::create();
				$search->setLimitOffset( $limit );
				//We need only main namespace results, ad that one
				//is searched by default
				//$search->setNamespaces( $this->namespaces);
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
							
							$this->processSearchResults( $titleMatches, 'title', $ret );
							$this->processSearchResults( $textMatches, 'text', $ret );
							
							$this->storeInCache($cacheKey, $ret, 1800 /*30min*/);
						} else {
							wfProfileOut( __METHOD__ );
							throw new EzApiException( 'Too many results' );
						}
					} else {
						wfProfileOut( __METHOD__ );
						throw new EzApiException( 'Search disabled' );
					}
				} else {
					wfProfileOut( __METHOD__ );
					throw new EzApiException( "Search error: {$search->getError()}");
				}
			}
		}
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}
	
	private function processSearchResults( $matches, $type, &$output ) {
		if ( $matches ) {
			if ( $matches->numRows() ) {
				global $wgContLang;
				/*$terms = $wgContLang->convertForSearchResult(
					$matches->termMatches()
				);*/
				
				$output[ "{$type}MatchesInfo" ] = $matches->getInfo();
				$output[ "{$type}Matches" ] = Array();
				
				while ( $result = $matches->next() ) {
					if ( !$result->isBrokenTitle() && !$result->isMissingRevision() ) {
						$title = $result->getTitle();
						$output[ "{$type}Matches" ][] = Array(
							'title' => $title->getText(),
							'link' => $title->getLocalUrl( array( 'useskin' => 'wikiaapp' ) )
							//'terms' => $terms
						);
					}
				}
			}
			
			$matches->free();
		}
	}
	
	private function generateCacheKey( $token ){
		return $this->app->wf->memcKey( $token, GameGuidesController::API_VERSION . '.' . GameGuidesController::API_REVISION ); 
	}
	
	private function loadFromCache($key){
		$this->app->wg->memc->get($key);
	}
	
	private function storeInCache( $key, $value, $duration = self::CACHE_DURATION ){
		$this->app->wg->memc->set( $key, $value, $duration );
	}
	
	public static function verifyElement( &$elem ){
		$elem = trim( $elem );
		return !empty( $elem );
	}
}