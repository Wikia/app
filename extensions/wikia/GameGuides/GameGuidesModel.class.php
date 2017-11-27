<?php
/**
 * A model for the Game Guides controller
 *
 * @author Federico "Lox" Lucignano
 * @deprecated
 */

class GameGuidesModel{
	/**
	 * the WikiFactory toggle that qualifies a wiki for being listed in the app
	 */
	const WF_WIKI_RECOMMEND_VAR = 'wgWikiaGameGuidesRecommend';
	const MEMCHACHE_KEY_PREFIX = 'GameGuides';
	const CACHE_DURATION = 86400;//24h
	const SEARCH_RESULTS_LIMIT = 100;
	const CATEGORY_RESULTS_LIMIT = 0;//no limits for now

	private $app;

	function __construct(){
		$this->app = F::app();
	}

	/*
	 * @brief Gets a list of recommended wikis through WikiFactory
	 *
	 * @param integer $limit [OPTIONAL] the maximum number of results
	 * @param int $batch [OPTIONAL] the batch of results, used only when $limit is passed in
	 *
	 * @return array a paginated batch (see wfPaginateArray), each item is an hash with the following keys:
	 * * string name wiki's name
	 * * string color wiki's wordmark text color
	 * * string backgroundColor wiki's background color
	 * * string domain wiki's domain
	 * * wordmarkUrl wiki's wordmark image URL
	 *
	 * @see wfPaginateArray
	 */
	public function getWikisList( $limit = null, $batch = 1 ){
		wfProfileIn( __METHOD__ );

		$cacheKey = $this->generateCacheKey( __METHOD__ );
		$games = $this->loadFromCache( $cacheKey );

		if ( empty( $games ) ) {
			$games = Array();
			$wikiFactoryRecommendVar = WikiFactory::getVarByName( self::WF_WIKI_RECOMMEND_VAR, null );

			if ( !empty( $wikiFactoryRecommendVar ) ) {
				$recommendedIds = WikiFactory::getCityIDsFromVarValue( $wikiFactoryRecommendVar->cv_variable_id, true, '=' );

				foreach( $recommendedIds as $wikiId ) {
					$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
					$wikiGames = WikiFactory::getVarValueByName( 'wgWikiTopics', $wikiId );
					$wikiDomain = preg_replace( '!^https?://!', '', WikiFactory::getVarValueByName( 'wgServer', $wikiId ));
					$wikiThemeSettings = WikiFactory::getVarValueByName( 'wgOasisThemeSettings', $wikiId);
					$wordmarkUrl = $wikiThemeSettings[ 'wordmark-image-url' ];
					$wordmarkType = $wikiThemeSettings[ 'wordmark-type' ];
					//$wikiLogo = WikiFactory::getVarValueByName( "wgLogo", $wikiId );

					$games[] = Array(
						'name' => ( !empty( $wikiThemeSettings[ 'wordmark-text' ] ) ) ? $wikiThemeSettings[ 'wordmark-text' ] : $wikiName,
						'games' => ( !empty( $wikiGames ) ) ? $wikiGames : '',
						'color' => ( !empty( $wikiThemeSettings[ 'wordmark-color' ] ) ) ? $wikiThemeSettings[ 'wordmark-color' ] : '#0049C6',
						'backgroundColor' => ( !empty( $wikiThemeSettings[ 'color-page' ] ) ) ? $wikiThemeSettings[ 'color-page' ] : '#FFFFFF',
						'domain' => $wikiDomain,
						'wordmarkUrl'=> ( $wordmarkType == 'graphic' && !empty( $wordmarkUrl ) ) ? $wordmarkUrl : ''
					);
				}
			} else {
				wfProfileOut( __METHOD__ );
				throw new WikiaException( 'WikiFactory variable \'' . self::WF_WIKI_RECOMMEND_VAR . '\' not found' );
			}

			$this->storeInCache( $cacheKey , $games );
		}

		$ret = wfPaginateArray( $games, $limit, $batch );

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/*
	 * @brief Returns a structure representing application-related content for the current wiki
	 *
	 * @return Array an hash with the following keys:
	 * * string searchURL the URL for the local Search page
	 * * array entries a list of contect categories, each item has the following structure:
	 * ** string title the label to use for this category
	 * ** string categoryName the actual name of the category
	 * ** string icon the icon ID to use for this category
	 */
	public function getWikiContents(){
		wfProfileIn( __METHOD__ );

		$cacheKey = $this->generateCacheKey( __METHOD__ );
		$ret = $this->loadFromCache( $cacheKey );

		if ( empty( $ret ) ) {
			$ret = Array();

			$searchTitle = Title::newFromText( 'Search', NS_SPECIAL );
			$ret[ 'searchURL' ] = $searchTitle->getLocalUrl( array( 'useskin' => GameGuidesController::SKIN_NAME ) );
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
					'categoryName' => ( !empty( $info[ 1 ] ) ) ? $info[ 1 ] : null,
					'icon' => ( !empty( $info[ 2 ] ) ) ? $info[ 2 ] : null
				);
			}

			$this->storeInCache($cacheKey , $ret);
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/*
	 * @brief Gets data for a Wiki's entry
	 *
	 * @param integer $limit [OPTIONAL] the maximum number of results for this call
	 * @param integer $batch [OPTIONAL] the batch of results, used only when $limit is passed in
	 * @param integer $totalLimit [OPTIONAL] the maximum total number of results to fetch from the selected category
	 *
	 * @return array a paginated batch (see wfPaginateArray), each item is an hash with the following keys:
	 * * string title content's title
	 * * string url content's URL (local to the wiki)
	 *
	 * @see wfPaginateArray
	 */
	public function getCategoryContents( $categoryName, $limit = null, $batch = 1, $totalLimit = self::CATEGORY_RESULTS_LIMIT ) {
		wfProfileIn( __METHOD__ );

		$categoryName = trim( $categoryName );
		$category = Category::newFromName( $categoryName );

		if ( $category ) {
			$cacheKey = $this->generateCacheKey(
				__METHOD__ .
				":{$category->getID()}" .
				":{$totalLimit}"
			);
			//$contents = $this->loadFromCache( $cacheKey );

			if ( empty( $contents ) ) {
				$contents = Array();
				$titles = $category->getMembers( $totalLimit );

				foreach( $titles as $title ) {
					$contents[] = array(
						'title' => $title->getText(),
						'url' => $title->getLocalUrl( array( 'useskin' => GameGuidesController::SKIN_NAME ) )
					);
				}

				$this->storeInCache( $cacheKey , $contents );
			}
		} else {
			wfProfileOut( __METHOD__ );
			throw new WikiaException( "No data for '{$categoryName}'" );
		}

		$ret = wfpaginateArray( $contents, $limit, $batch );

		wfProfileOut( __METHOD__ );
		return $ret;
	}


	/*
	 * @brief Searches for a term on the current wiki
	 *
	 * @param string $term the term to search for
	 * @param integer $totalLimit [OPTIONAL] the maximum total number of results to fetch from the search index
	 *
	 * @return array a results set produced by WikiaSearch
	 * @see WikiaSearch
	 */
	public function getSearchResults( $term, $totalLimit = self::SEARCH_RESULTS_LIMIT ){
		wfProfileIn( __METHOD__ );

		$term = trim( $term );
		$ret = array();

		if ( !empty( $this->app->wg->EnableWikiaSearchExt ) && !empty( $term ) ) {
			wfloadExtensionMessages( 'GameGuides' );

			$cacheKey = $this->generateCacheKey(
				__METHOD__ .
				':' .
				str_replace( array( ' ', "\n", "\t", "\r" ),  '_', $term ) ./* no spaces in memcache keys */
				":{$totalLimit}"
			);
			$ret = $this->loadFromCache( $cacheKey );

			if ( empty( $ret ) ) {

				$resultSet = $this->getResultSet( $term, $totalLimit );

				$ret['textResults'] = array();
				$count = 0;

				if ( $resultSet->hasResults() ) {
					$textResults = array();
					$mwService = new Wikia\Search\MediaWikiService;
					foreach ( $resultSet as $result ) {
						try {
							$textResults[] = array(
									'textForm' => $result->getTitle(),
									'urlForm' => $mwService->getLocalUrlForPageId( $result['pageid'], array( 'useskin' => GameGuidesController::SKIN_NAME ) )
									);
							$count++;
						} catch ( Exception $e ) {} // result is probably stale/deleted
					}

					$ret['textResults'] = $textResults;
					$ret['count'] = $count;
				}
			}

			$this->storeInCache( $cacheKey , $ret );
		}

		wfProfileOut( __METHOD__ );
		return $ret;
	}

	/**
	 * Perform a search query against NS_MAIN given a term and total limit
	 * @param string $term
	 * @param int $limit
	 */
	public function getResultSet( $term, $totalLimit ) {
		$wikiaSearchConfig = new Wikia\Search\Config();
		$wikiaSearchConfig	->setNamespaces	( array( NS_MAIN ) )
							->setQuery		( $term )
							->setLimit		( $totalLimit );

		$wikiaSearch = (new Wikia\Search\QueryService\Factory)->getFromConfig( $wikiaSearchConfig );
		return $wikiaSearch->search( $wikiaSearchConfig );
	}

	private function generateCacheKey( $token ){
		return wfMemcKey( $token, GameGuidesController::API_VERSION . '.' . GameGuidesController::API_REVISION . '.' . GameGuidesController::API_MINOR_REVISION );
	}

	private function loadFromCache( $key ){
		return $this->app->wg->memc->get( $key );
	}

	private function storeInCache( $key, $value, $duration = self::CACHE_DURATION ){
		$this->app->wg->memc->set( $key, $value, $duration );
	}

	public static function verifyElement( &$elem ){
		$elem = trim( $elem );
		return !empty( $elem );
	}
}
