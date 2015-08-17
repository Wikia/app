<?php

use Wikia\Logger\WikiaLogger;

abstract class BaseRssModel extends WikiaService {

	const FIELD_TIMESTAMP = 'timestamp';
	const SOURCE_HUB = 'hub';
	const SOURCE_GENERATOR = 'generator';
	const ENDPOINT_ASSIMPLEJSON = 'api/v1/Articles/AsSimpleJson';
	const ENDPOINT_DETAILS = 'api/v1/Articles/Details';
	const DATETIME_FORMAT = 'Y-m-d H:i:s';
	/**
	 * For how long the RSS item should be unique
	 */
	const UNIQUE_URL_TTL_HOURS = 336;

	/**
	 * For how long to wait until looking for new content
	 */
	const FRESH_CONTENT_TTL_HOURS = 4;
	/**
	 * RSS items limit
	 */
	const ROWS_LIMIT = 15;
	const MIN_IMAGE_SIZE = 200;

	protected $nsBlogs = [ NS_BLOG_ARTICLE => true ];

	public abstract function getFeedTitle();

	public abstract function getFeedDescription();

	public static function getFeedLanguage() {
		return static::LANGUAGE;
	}

	public static function getFeedName() {
		return static::FEED_NAME . static::getFeedLanguage();
	}

	public function getFeedData() {
		return $this->getLastRecordsFromDb( static::getFeedName(), static::MAX_NUM_ITEMS_IN_FEED );
	}

	public function generateFeedData() {
		$duplicates = $this->getLastDuplicatesFromDb( static::getFeedName() );
		$timestamp = $this->getLastFeedTimestamp( static::getFeedName() ) + 1;
		return $this->loadData( $timestamp, $duplicates );
	}

	protected abstract function loadData( $lastTimestamp, $duplicates );

	/**
	 * @param $feedName
	 * @return BaseRssModel
	 */
	public static function newFromName( $feedName ) {
		switch ( $feedName ) {
			case GamesRssModel::getFeedName():
				return new GamesRssModel();
			case GamesDeHubOnlyRssModel::getFeedName():
				return new GamesDeHubOnlyRssModel();
			case TvRssModel::getFeedName():
				return new TvRssModel();
			case LifestyleHubOnlyRssModel::getFeedName():
				return new LifestyleHubOnlyRssModel();
			case EntertainmentHubOnlyRssModel::getFeedName():
				return new EntertainmentHubOnlyRssModel();
			case EntertainmentDeHubOnlyRssModel::getFeedName():
				return new EntertainmentDeHubOnlyRssModel();
			case MarvelRssModel::getFeedName():
				return new MarvelRssModel();
			case StarWarsRssModel::getFeedName():
				return new StarWarsRssModel();
			default:
				return null;
		}
	}

	/**
	 * @return DatabaseBase
	 */
	protected function getDbSlave() {
		static $db = null;
		if ( $db === null ) {
			global $wgExternalDatawareDB;
			$db = wfGetDB( DB_SLAVE, null, $wgExternalDatawareDB );
		}
		return $db;
	}

	/**
	 * @return DatabaseBase
	 */
	protected function getDbMaster() {
		static $db = null;
		if ( $db === null ) {
			global $wgExternalDatawareDB;
			$db = wfGetDB( DB_MASTER, null, $wgExternalDatawareDB );
		}
		return $db;
	}

	protected function addFeedsToDb( $rows, $feed ) {
		$feed = self::getStagingPrefix() . $feed;
		$db = $this->getDbMaster();
		$db->begin();
		$nowDate = date( self::DATETIME_FORMAT );
		$numAdded = 0;
		foreach ( $rows as $url => $item ) {
			$numAdded += ( new WikiaSQL() )
				->INSERT( 'wikia_rss_feeds' )
				->SET( 'wrf_wikia_id', $item[ 'wikia_id' ] )
				->SET( 'wrf_page_id', $item[ 'page_id' ] )
				->SET( 'wrf_url', $url )
				->SET( 'wrf_feed', $feed )
				->SET( 'wrf_pub_date', date( self::DATETIME_FORMAT, $item[ 'timestamp' ] ) )
				->SET( 'wrf_title', $item[ 'title' ] )
				->SET( 'wrf_description', $item[ 'description' ] )
				->SET( 'wrf_img_url', $item[ 'img' ][ 'url' ] )
				->SET( 'wrf_img_width', $item[ 'img' ][ 'width' ] )
				->SET( 'wrf_img_height', $item[ 'img' ][ 'height' ] )
				->SET( 'wrf_ins_date', $nowDate )
				->SET( 'wrf_source', $item[ 'source' ] )
				->run( $db );
		}
		$db->commit();
		return $numAdded;
	}

	protected function isFreshContentInDb( $feed, $hours = self::FRESH_CONTENT_TTL_HOURS ) {
		//select count(1) as c from wikia_rss_feeds where wrf_pub_date >= '2014-05-20 00:00:00' AND wrf_feed = 'tv';
		$feed = self::getStagingPrefix() . $feed;
		$startTime = date( self::DATETIME_FORMAT, strtotime( sprintf( 'now - %uhour', $hours ) ) );
		$links = ( new WikiaSQL() )
			->SELECT( "count(1)" )->AS_( 'c' )
			->FROM( 'wikia_rss_feeds' )
			->WHERE( 'wrf_pub_date' )
			->GREATER_THAN_OR_EQUAL( $startTime )
			->AND_( 'wrf_feed' )->EQUAL_TO( $feed )
			->LIMIT( 1 )
			->run( $this->getDbSlave(), function ( $result ) {
				$row = $result->fetchObject( $result );
				if ( $row && isset( $row->c ) ) {
					return (int)$row->c;
				}

				return 0;
			} );

		return $links;
	}

	protected function getLastFeedTimestamp( $feed ) {
		//select UNIX_TIMESTAMP(wrf_pub_date) AS t wikia_rss_feeds where wrf_feed = 'tv' ORDER BY wrf_pub_date DESC limit 1
		$feed = self::getStagingPrefix() . $feed;
		$timestamp = ( new WikiaSQL() )
			->SELECT( "UNIX_TIMESTAMP(wrf_pub_date)" )->AS_( 't' )
			->FROM( 'wikia_rss_feeds' )
			->WHERE( 'wrf_feed' )->EQUAL_TO( $feed )
			->ORDER_BY( 'wrf_pub_date DESC' )
			->LIMIT( 1 )
			->run( $this->getDbSlave(), function ( $result ) {
				$row = $result->fetchObject( $result );
				if ( $row && isset( $row->t ) ) {
					return (int)$row->t;
				}

				return 0;
			} );

		return $timestamp;
	}

	protected function getLastInsertFeedTimestamp( $feed, $source ) {
		$feed = self::getStagingPrefix() . $feed;
		$timestamp = ( new WikiaSQL() )
			->SELECT( "UNIX_TIMESTAMP(wrf_ins_date)" )->AS_( 't' )
			->FROM( 'wikia_rss_feeds' )
			->WHERE( 'wrf_feed' )->EQUAL_TO( $feed )
			->AND_( 'wrf_source' )->EQUAL_TO( $source )
			->ORDER_BY( 'wrf_ins_date DESC' )
			->LIMIT( 1 )
			->run( $this->getDbSlave(), function ( $result ) {
				$row = $result->fetchObject( $result );
				if ( $row && isset( $row->t ) ) {
					return (int)$row->t;
				}

				return 0;
			} );

		return $timestamp;
	}

	protected function getLastRecordsFromDb( $feed, $limit = self::ROWS_LIMIT, $useMaster = false ) {
		$feed = self::getStagingPrefix() . $feed;
		$db = $useMaster ? $this->getDbMaster() : $this->getDbSlave();
		$wikisData = ( new WikiaSQL() )
			->SELECT( ' * ' )
			->FROM( 'wikia_rss_feeds' )
			->WHERE( 'wrf_feed' )->EQUAL_TO( $feed )
			->ORDER_BY( 'wrf_pub_date DESC' )
			->LIMIT( $limit )
			->runLoop( $db, function ( &$wikisData, $row ) {

					$wikisData[ $row->wrf_url ] = [
						'wikia_id' => $row->wrf_wikia_id,
						'page_id' => $row->wrf_page_id,
						'timestamp' => strtotime( $row->wrf_pub_date ),
						'title' => $row->wrf_title,
						'description' => $row->wrf_description,
						'img' => [
							'url' => $row->wrf_img_url,
							'width' => $row->wrf_img_width,
							'height' => $row->wrf_img_height
						]
					];
				}
			);

		return $wikisData;
	}

	protected function getLastDuplicatesFromDb( $feed, $maxHours = self:: UNIQUE_URL_TTL_HOURS ) {
		$feed = self::getStagingPrefix() . $feed;
		$fromTime = date( self::DATETIME_FORMAT, strtotime( sprintf( 'now - %uhour', $maxHours ) ) );
		$wikisData = ( new WikiaSQL() )
			->SELECT( ' wrf_url ' )
			->FROM( 'wikia_rss_feeds' )
			->WHERE( 'wrf_feed' )->EQUAL_TO( $feed )
			->AND_( 'wrf_pub_date' )->GREATER_THAN_OR_EQUAL( $fromTime )
			->ORDER_BY( 'wrf_pub_date' )
			->runLoop( $this->getDbSlave(), function ( &$wikisData, $row ) {

					$wikisData[ $row->wrf_url ] = true;
				}
			);

		return $wikisData;
	}

	protected function deleteRow( $wikiaId, $pageId, $feed ){
		$feed = self::getStagingPrefix() . $feed;
		$db = $this->getDbMaster();
		( new WikiaSQL() )
			->DELETE( "wikia_rss_feeds" )
			->WHERE( "wrf_wikia_id" )->EQUAL_TO( $wikiaId )
			->AND_( 'wrf_page_id' )->EQUAL_TO( $pageId )
			->AND_( 'wrf_feed' )->EQUAL_TO( $feed )
			->run( $db );
	}

	protected function getWikiService() {
		return new WikiService();
	}

	protected function getArticleDetail( $wikiId, $articleId ) {
		$res = ApiService::foreignCall( WikiFactory::IDtoDB( $wikiId ), [ 'ids' => $articleId ], self::ENDPOINT_DETAILS );
		if ( !$res ) {
			return [ ];
		}

		$article = $res[ 'items' ][ $articleId ];
		if ( !$article[ 'thumbnail' ] ) {
			$wikiService = $this->getWikiService();
			$article[ 'thumbnail' ] = $wikiService->getWikiWordmark( $wikiId );
		} else {
			$article[ 'thumbnail' ] = ImagesService::getFileUrlFromThumbUrl( $article[ 'thumbnail' ] );
		}
		return [ 'img' => [
			'url' => $article[ 'thumbnail' ],
			'width' => $article[ 'original_dimensions' ][ 'width' ] < self::MIN_IMAGE_SIZE ? self::MIN_IMAGE_SIZE : $article[ 'original_dimensions' ][ 'width' ],
			'height' => $article[ 'original_dimensions' ][ 'height' ] < self::MIN_IMAGE_SIZE ? self::MIN_IMAGE_SIZE : $article[ 'original_dimensions' ][ 'height' ]
		],
			'title' => $article[ 'title' ]
		];
	}

	protected function getArticleDescription( $wikiId, $articleId ) {
		$res = ApiService::foreignCall( WikiFactory::IDtoDB( $wikiId ), [ 'id' => $articleId ], self::ENDPOINT_ASSIMPLEJSON );
		if ( !$res ) {
			return '';
		}
		foreach ( $res[ 'sections' ] as $section ) {
			if ( is_array( $section[ 'content' ] ) ) {
				foreach ( $section[ 'content' ] as $content ) {
					if ( $content[ 'type' ] === 'paragraph' ) {
						return $content[ 'text' ];
					}
				}
			}
		}
	}

	protected function processItems( $rawData ) {
		$out = [ ];
		$time = time();
		foreach ( $rawData as $item ) {

			$detailsFields = [ 'title', 'img' ];
			$details = null;
			foreach ( $detailsFields as $field ) {
				if ( empty( $item[ $field ] ) ) {
					if ( empty( $details ) ) {
						$details = $this->getArticleDetail( $item[ 'wikia_id' ], $item[ 'page_id' ] );
					}
					$item[ $field ] = $details[ $field ];
				}
			}

			if ( empty( $item[ 'timestamp' ] ) ) {
				$item[ 'timestamp' ] = $time--;
			}

			if ( empty( $item[ 'description' ] ) ) {
				$item[ 'description' ] = $this->getArticleDescription( $item[ 'wikia_id' ], $item[ 'page_id' ] );;
			}

			$item = $this->formatTitle( $item );

			$out[ $item[ 'url' ] ] = $item;
		}

		$out = $this->fixDuplicatedTimestamps( $out );

		return $out;
	}

	abstract protected function formatTitle( $item );


	protected function removeDuplicates( $rawData, $duplicates = [ ] ) {
		if ( !is_array( $rawData ) ) {
			$rawData = [ ];
		}
		if ( !is_array( $duplicates ) ) {
			$duplicates = [ ];
		}

		foreach ( $rawData as $key => $item ) {
			if ( array_key_exists( $item[ 'url' ], $duplicates ) ) {
				WikiaLogger::instance()->info( __METHOD__, [ 'item' => $item ] );
				unset( $rawData[ $key ] );
			}
		}

		return $rawData;
	}

	protected function getPopularContent( $rawData, $wikis, $duplicates, $numResults = 0 ) {
		if ( empty( $wikis ) ) {
			return [ ];
		}
		$model = new PopularArticlesModel();

		$perWiki = ceil( $numResults / count( $wikis ) );
		$numberOfItemsToAdd = [ ];
		foreach ( $wikis as $wid ) {
			if ( $perWiki > 0 ) {
				$numberOfItemsToAdd[ $wid ] = $perWiki;
			}
			if ( $numResults === 0 ) {
				break;
			}
			$numResults -= $perWiki;
			if ( $perWiki > $numResults ) {
				$perWiki = $numResults;
				$numResults = 0;
			}
		}

		foreach ( $wikis as $wid ) {
			$list = $model->getArticles( $wid );
			foreach ( $list as $item ) {
				if ( !array_key_exists( $item[ 'url' ], $duplicates ) ) {
					$item[ 'source' ] = self::SOURCE_GENERATOR;
					$rawData[ ] = $item;
					if ( --$numberOfItemsToAdd[ $wid ] == 0 ) {
						break;
					}
				}
			}
		}
		return $rawData;
	}

	protected function getDataFromHubs( $hubId, $fromTimestamp, $duplicates = [ ] ) {
		$model = new HubRssFeedModel( static::getFeedLanguage() );
		$v3 = $model->getRealDataV3( $hubId, null, true );
		foreach ( $v3 as $key => $item ) {
			if ( $item[ 'timestamp' ] < $fromTimestamp ) {
				unset( $v3[ $key ] );
			} else {
				//add url as item for compatibility
				$v3[ $key ][ 'url' ] = $key;
			}
		}
		$hubData = $this->removeDuplicates( $v3, $duplicates );
		$out = $this->findIdForUrls( $hubData, self::SOURCE_HUB . '_' . $hubId );
		return $out;
	}

	protected function findIdForUrls( $urls, $source = null ) {
		$data = [ ];

		if ( !empty( $urls ) ) {
			foreach ( $urls as $item ) {
				$url = $item['url'];

				$result = GlobalTitle::explodeURL( $url );
				$wikia_id = $result['wikiId'];
				$articleName = $result['articleName'];

				if ( !( empty( $wikia_id ) || empty( $articleName ) ) ) {
					$res = ApiService::foreignCall(WikiFactory::IDtoDB($wikia_id),[
						'action' => 'query',
						'titles' => $articleName,
						'indexpageids',
						'format' => 'json'
					]);

					if(!empty($res['query']['pages'])) {
						$pages = array_keys( $res['query']['pages'] );
						$page_id = array_shift( $pages );
						$newItem = $item;
						$newItem[ 'wikia_id' ] = $wikia_id;
						$newItem[ 'page_id' ] = $page_id;
						$newItem[ 'source' ] = $source;
						$data[ ] = $newItem;
					}
				}
			}
		}

		return $data;
	}

	protected function finalizeRecords( $rawData, $feedName ) {
		$this->cleanDeadUrlsInDB( $feedName );
		$items = $this->processItems( $rawData );
		return $this->addFeedsToDb( $items, $feedName );
	}

	protected function makeBlogTitle( $item ) {
		if ( array_key_exists( $item[ 'ns' ], $this->nsBlogs ) ) {
			if ( !array_key_exists( 'wikititle', $item ) || !$item[ 'wikititle' ] ) {
				$info = WikiFactory::getWikiByID( $item[ 'wikia_id' ] );
				$item[ 'wikititle' ] = $info->city_title;
			}
			$t = GlobalTitle::newFromId( $item[ 'page_id' ], $item[ 'wikia_id' ] );
			if ( $t instanceof GlobalTitle ) {
				$orgTitle = $t->getText();
				$pos = strrpos( $orgTitle, '/' );
				if ( $pos ) {
					$pos++;
				}
				$title = substr( $orgTitle, $pos );
				$item[ 'title' ] = sprintf( '%s from %s', $title, $item[ 'wikititle' ] );
			}
		}
		return $item;
	}

	public static function getStagingPrefix() {
		global $wgDevelEnvironment, $wgStagingEnvironment;

		if ( $wgDevelEnvironment || $wgStagingEnvironment ) {
			return 'stag_';
		}

		if ( !empty( $_ENV[ 'WIKIA_ENVIRONMENT' ] ) && $_ENV[ 'WIKIA_ENVIRONMENT' ] == 'sandbox' ) {
			return 'stag_';
		}
		return '';
	}

	/**
	 * Fixing array of items in such way - that items will not contain duplicated timestamps
	 */
	protected function fixDuplicatedTimestamps( $items ) {

		if ( empty( $items ) ) {
			$emptyArray = [ ];
			return $emptyArray;
		}

		$uniqueTimestamps =
			$this->countUniqueTimestampsOccurrence( $items );

		if ( count( $items ) == count( $uniqueTimestamps ) ) {
			// Number of unique timestamps == number of items
			// This means that there is no timestamps conflicts
			return $items;
		}

		foreach ( $items as $key => $value ) {
			$timestamp = $value[ self::FIELD_TIMESTAMP ];

			$timestampIsNotUnique =
				$uniqueTimestamps[ $timestamp ] > 1;

			if ( $timestampIsNotUnique ) {

				$newTimestamp =
					$this->findAvailableTimestamp( $timestamp, $uniqueTimestamps );

				// Updating timestamp
				$items[ $key ][ self::FIELD_TIMESTAMP ] = $newTimestamp;

				// Mark new timestamp as unavailable for future searching
				$uniqueTimestamps[ $newTimestamp ] = 1;

				// decrease number of occurrences of conflicted timestamp
				$uniqueTimestamps[ $timestamp ]--;
			}
		}

		// Returning items without duplicating timestamps
		return $items;
	}

	/**
	 * Count occurrence of each unique timestamp
	 */
	protected function countUniqueTimestampsOccurrence( $itemsMap ) {
		$timestampsCount = [ ];
		foreach ( $itemsMap as $key => $value ) {
			$timestamp = $value[ self::FIELD_TIMESTAMP ];

			if ( empty( $timestampsCount[ $timestamp ] ) ) {
				$timestampsCount[ $timestamp ] = 1;
			} else {
				$timestampsCount[ $timestamp ]++;
			}
		}
		return $timestampsCount;
	}

	/**
	 * Finding available timestamp (by increasing current timestamp)
	 */
	protected function findAvailableTimestamp( $timestamp, $uniqueTimestampsCount ) {
		$newTimestamp = $timestamp + 1;
		while ( !empty( $uniqueTimestampsCount[ $newTimestamp ] ) ) {
			$newTimestamp++;
		}
		return $newTimestamp;
	}

	/**
	 * Checks if response code is different than 404. WE don't care about 503 etc as they might change
	 * @param $wikiaid
	 * @param $pageid
	 * @return bool
	 */
	protected function checkTitleExists( $wikiaid, $pageid  ) {
		$t = GlobalTitle::newFromId( $pageid , $wikiaid);
		return ($t instanceof GlobalTitle) && $t->exists();
	}

	/**
	 * Removes "dead" urls from DB
	 * @param $feedName
	 */
	protected function cleanDeadUrlsInDB( $feedName ) {
		$urlsMap = $this->getFeedData();
		foreach ( $urlsMap as $url => $item ) {
			if ( $item[ 'wikia_id' ] && $item[ 'page_id' ] && !$this->checkTitleExists(  $item[ 'wikia_id' ], $item[ 'page_id' ]  ) ) {
				$this->deleteRow( $item[ 'wikia_id' ], $item[ 'page_id' ], $feedName );
			}
		}
	}

}
