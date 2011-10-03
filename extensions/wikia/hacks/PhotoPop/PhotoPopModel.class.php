<?php
/**
 * A model for the PhotoPop controller
 * 
 * @author Federico "Lox" Lucignano
 */

class PhotoPopModel extends WikiaModel{
	//the WikiFactory toggle that qualifies a wiki for being listed in the game
	const WF_SWITCH_NAME = 'wgEnablePhotoPopExt';
	const WF_SETTINGS_NAME = 'wgPhotoPopSettings';
	const GAME_ICON_WIDTH = 120;
	const GAME_ICON_HEIGHT = 120;
	const MEMCHACHE_KEY_PREFIX = 'PhotoPop';
	const CACHE_DURATION = 86400;//24h
	const CATEGORY_RESULTS_LIMIT = 0;//no limits for now
	const ENABLE_CACHE = false;//use for debugging purposes
	
	//TODO: temporary, remove when the list of games will be retrieved from WF
	//dbName => categoryName
	private $gamesData = array(
		'trueblood' => "Characters",
		'glee' => "Characters",
		'lyricwiki' => "Albums_released_in_2011",
		'muppet' => "The_Muppets_Characters",
		'dexter' => "Characters",
		'futurama' => "Characters",
		'trueblood' => "Characters",
		'twilightsaga' => "Twilight_Characters"
	);
	
	/*
	 * @brief Gets a list of games (wikis) wikis through WikiFactory
	 * 
	 * @param integer $limit [OPTIONAL] the maximum number of results
	 * @param int $batch [OPTIONAL] the batch of results, used only when $limit is passed in
	 * 
	 * @return array a paginated batch (see wfPaginateArray), each item is an hash with the following keys:
	 * * string name wiki's name
	 * * string domain wiki's domain
	 * * wordmarkUrl wiki's wordmark image URL
	 * 
	 * @see wfPaginateArray
	 */
	public function getWikisList( $limit = null, $batch = 1 ){
		$this->wf->profileIn( __METHOD__ );
		
		$cacheKey = $this->generateCacheKey( __METHOD__ );
		$games = $this->loadFromCache( $cacheKey );
		
		if ( empty( $games ) ) {
			$games = Array();
			$wikiFactoryRecommendVar = WikiFactory::getVarByName( self::WF_SWITCH_NAME, null );
			
			if ( !empty( $wikiFactoryRecommendVar ) ) {
				$gamesIds = WikiFactory::getCityIDsFromVarValue( $wikiFactoryRecommendVar->cv_variable_id, true, '=' );
				
				foreach ( $gamesIds as $wikiId ) {
					$gameSettings = WikiFactory::getVarValueByName( self::WF_SETTINGS_NAME, $wikiId );
					$matches = array();
					$game = new stdClass();
					$result = preg_match_all( '/([^=|]+)=([^|]+)/m' ,$gameSettings, $matches );
					
					if ( $result > 0 && !empty( $matches[1] ) && !empty( $matches[2] ) ){
						foreach( $matches[1] as $index => $setting ){
							if ( !empty( $matches[2][$index] ) ) {
								$game->$setting = $matches[2][$index];
							}
						}
					}
					
					if( !empty( $game->category ) ) {
						$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
						$wikiThemeSettings = WikiFactory::getVarValueByName( 'wgOasisThemeSettings', $wikiId);
						
						$game->name = ( !empty( $wikiThemeSettings[ 'wordmark-text' ] ) ) ? $wikiThemeSettings[ 'wordmark-text' ] : $wikiName;
						$game->dbName = WikiFactory::IDtoDB( $wikiId );
						$game->domain = str_replace('http://', '', WikiFactory::getVarValueByName( 'wgServer', $wikiId ));
						
						$games[] = $game;
					}
				}
			} else {
				$this->wf->profileOut( __METHOD__ );
				throw new WikiaException( 'WikiFactory variable \'' . self::WF_SWITCH_NAME . '\' not found' );
			}
			
			$this->storeInCache( $cacheKey , $games );
		}
		
		$ret = $this->app->wf->paginateArray( $games, $limit, $batch );
		
		$this->app->wf->profileOut( __METHOD__ );
		return $ret;
	}
	
	/*
	 * @brief Gets data for a Wiki's entry
	 * 
	 * @param string $categoryName the name of the category to pull contents from
	 * @param integer $imageWidth the width of the image to pull from the articles
	 * @param integer $imageHeight the height of the image to pull from the articles
	 * 
	 * @return stdClass an object with two properties, articles and titles, each
	 * of them is a collection of objects with the following properties
	 * - integer id the article's ID
	 * - string text the article's title
	 * - string url the article's local URL
	 * - string image the url to the image for the article (only in the article property collection)
	 */
	public function getGameContents( $categoryName, $imageWidth, $imageHeight ) {
		$this->app->wf->profileIn( __METHOD__ );
		
		$cacheKey = $this->generateCacheKey(
			__METHOD__ .
			//memcache doesn't like spaces in keys
			":" . str_replace( ' ', '_', $categoryName )
		);
		
		$contents = $this->loadFromCache( $cacheKey );
		
		if ( empty( $contents ) ) {
			$category = F::build( 'Category', array( $categoryName ), 'newFromName' );
			
			if ( $category instanceof Category ) {
				$articles = Array();
				$titles = $category->getMembers();
				
				foreach ( $titles as $title ) {
					if ( $title->getNamespace() == NS_MAIN ){
						$obj = new stdClass();
						$obj->id = $title->getArticleID();
						$obj->text = $title->getText();
						$obj->url = $title->getLocalURL();
						
						$articles[$obj->id] = $obj;
					}
				}
				
				$resp = $this->app->sendRequest( 'ImageServingController', 'index', array( 'ids' => array_keys( $articles ), 'height' => $imageHeight, 'width' => $imageWidth, 'count' => 1 ) );
				
				$images = $resp->getVal( 'result' );
				
				foreach ( $articles as $id => $item ) {
					if ( !empty( $images[$id][0]['url'] ) ) {
						$item->image = $images[$id][0]['url'];
					}
					
					$contents[] = $item;
				}
				
				$this->storeInCache( $cacheKey , $contents );
			} else {
				$this->wf->profileOut( __METHOD__ );
				throw new WikiaException( "No data for '{$categoryName}'" );
			}
		}
		
		$this->app->wf->profileOut( __METHOD__ );
		return $contents;
	}
	
	public function getIconUrl( $titleName ){
		$this->app->wf->profileIn( __METHOD__ );
		
		if ( empty( $titleName ) ) {
			return null;
		}
		
		$cacheKey = $this->generateCacheKey(
			__METHOD__ .
			//memcache doesn't like spaces in keys
			":" . str_replace( ' ', '_', $titleName )
		);
		
		$contents = $this->loadFromCache( $cacheKey );
		
		if ( empty( $contents ) ) {
			$title = F::build( 'Title', array( $titleName, NS_FILE ), 'newFromText' );
			
			if ( $title instanceof Title ) {
				$id = $title->getArticleId();
				$resp = $this->app->sendRequest( 'ImageServingController', 'index', array( 'ids' => array( $id ), 'height' => self::GAME_ICON_HEIGHT, 'width' => self::GAME_ICON_WIDTH, 'count' => 1 ) );

				$images = $resp->getVal( 'result' );
				
				if ( !empty( $images[$id][0]['url'] ) ) {
					$contents = $images[$id][0]['url'];
					$this->storeInCache( $cacheKey , $contents );
				}
			}
		}
		
		$this->app->wf->profileOut( __METHOD__ );
		
		return $contents;
	}
	
	private function generateCacheKey( $token ){
		return $this->wf->memcKey( $token ); 
	}
	
	private function loadFromCache( $key ){
		return ( self::ENABLE_CACHE ) ? $this->wg->memc->get( $key ) : null;
	}
	
	private function storeInCache( $key, $value, $duration = self::CACHE_DURATION ){
		if ( self::ENABLE_CACHE ) {
			$this->wg->memc->set( $key, $value, $duration );
		}
	}
}