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
	const MEMCACHE_GLOBAL_KEY_TOKEN = 'listWikis';
	const CACHE_DURATION = 14400;//4h
	const CATEGORY_RESULTS_LIMIT = 0;//no limits for now
	const ENABLE_CACHE = true;//use for debugging purposes
	
	/*
	 * @brief Gets a list of games (wikis) wikis through WikiFactory
	 *
	 * @return array a paginated batch (see wfPaginateArray), each item is an hash with the following keys:
	 * * string name wiki's name
	 * * string domain wiki's domain
	 * * wordmarkUrl wiki's wordmark image URL
	 *
	 * @see wfPaginateArray
	 */
	public function getWikisList(){
		wfProfileIn( __METHOD__ );

		$cacheKey = $this->getGlobalCacheKey( self::MEMCACHE_GLOBAL_KEY_TOKEN );
		$ret = $this->loadFromCache( $cacheKey );

		if ( empty( $ret ) ) {
			$ret = Array();
			$wikiFactoryRecommendVar = WikiFactory::getVarByName( self::WF_SWITCH_NAME, null );

			if ( !empty( $wikiFactoryRecommendVar ) ) {
				$gamesIds = WikiFactory::getCityIDsFromVarValue( $wikiFactoryRecommendVar->cv_variable_id, true, '=' );

				foreach ( $gamesIds as $wikiId ) {
					$game = $this->getSettings( $wikiId );

					if( !empty( $game ) ) {
						$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
						$wikiThemeSettings = WikiFactory::getVarValueByName( 'wgOasisThemeSettings', $wikiId);

						$game->name = ( !empty( $wikiThemeSettings[ 'wordmark-text' ] ) ) ? $wikiThemeSettings[ 'wordmark-text' ] : $wikiName;
						$game->id = WikiFactory::IDtoDB( $wikiId );
						$game->domain = str_replace('http://', '', WikiFactory::getVarValueByName( 'wgServer', $wikiId ));

						$ret[$game->id] = $game;
					}
				}
			} else {
				wfProfileOut( __METHOD__ );
				throw new WikiaException( 'WikiFactory variable \'' . self::WF_SWITCH_NAME . '\' not found' );
			}

			$this->storeInCache( $cacheKey , $ret );
		}

		wfProfileOut( __METHOD__ );
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
		wfProfileIn( __METHOD__ );

		$cacheKey = wfMemcKey( __METHOD__, $categoryName );
		$contents = $this->loadFromCache( $cacheKey );

		if ( empty( $contents ) ) {
			$category = Category::newFromName( $categoryName );

			if ( $category instanceof Category && $category->getID() !== false ) {
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

				$resp = $this->app->sendRequest( 'ImageServing', 'index', array( 'ids' => array_keys( $articles ), 'height' => $imageHeight, 'width' => $imageWidth, 'count' => 1 ) );
				$val = $resp->getVal( 'result' );
				
				if( $resp->getVal( 'status' ) == 'error' ) {
					wfProfileOut( __METHOD__ );
					throw new WikiaException( 'Fetching images error: ' . $val );
				} else {
					$images = $val;
	
					foreach ( $articles as $id => $item ) {
						if ( !empty( $images[$id][0]['url'] ) ) {
							$url = $images[$id][0]['url'];
							//most of productionimages are not available on devbox
							//this enables testing the game with real images
							$item->image = ( $this->wg->DevelEnvironment ) ? preg_replace('#http://[^/]+/#i', 'http://images.wikia.com/', $url) : $url;
						}
	
						$contents[] = $item;
					}
	
					$this->storeInCache( $cacheKey , $contents );
				}
			} else {
				wfProfileOut( __METHOD__ );
				throw new WikiaException( "No data for '{$categoryName}'" );
			}
		}

		wfProfileOut( __METHOD__ );
		return $contents;
	}

	public function getImageUrl( $titleName ){
		wfProfileIn( __METHOD__ );

		if ( empty( $titleName ) ) {
			wfProfileOut( __METHOD__ );
			return null;
		}

		$title = Title::newFromText( $titleName, NS_FILE );
		$contents = null;

		if ( $title instanceof Title && $title->exists() ) {
			$file = wfFindFile($title);

			if ( !empty( $file ) ) {
				$contents = wfReplaceImageServer( $file->getFullUrl() );
			}
		}

		wfProfileOut( __METHOD__ );

		return $contents;
	}

	public function getSettings( $wikiId ){
		wfProfileIn( __METHOD__ );
		
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

		wfProfileOut( __METHOD__ );
		return ( !empty( $game->category ) ) ? $game : null;
	}

	public function saveSettings( $wikiId, $categoryName, $iconUrl, $watermarkUrl ){
		wfProfileIn( __METHOD__ );

		$values = array();
		$ret = false;

		if( !empty( $categoryName ) ) {
			$values[] = "category={$categoryName}";
		}

		if( !empty( $iconUrl ) ) {
			$values[] = "thumbnail={$iconUrl}";
		}

		if( !empty( $watermarkUrl ) ) {
			$values[] = "watermark={$watermarkUrl}";
		}

		if ( !empty( $values ) ) {
			$ret = WikiFactory::setVarByName( self::WF_SETTINGS_NAME, $wikiId, implode( '|', $values ), "Updating PhotoPop settings" );
			
			//force the list of wikis' cache to be rebuilt next time
			$this->wg->memc->delete( $this->getGlobalCacheKey( self::MEMCACHE_GLOBAL_KEY_TOKEN ) );
		}

		wfProfileOut( __METHOD__ );

		return $ret;
	}

	private function getGlobalCacheKey( $token ){
		//using wfForeignMemcKey to get  global key that can be accessed/purged from wherever
		return wfForeignMemcKey( '', self::MEMCHACHE_KEY_PREFIX, $token );
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