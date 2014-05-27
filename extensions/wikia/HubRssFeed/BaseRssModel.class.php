<?php

abstract class BaseRssModel extends WikiaService {

	const GAMES_FEED = 'games';
	const TV_FEED = 'tv';
	const SOURCE_HUB = 'hub';
	const SOURCE_GENERATOR = 'generator';
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

	protected $forceRegenerateFeed = false;
	protected $nsBlogs = [ NS_BLOG_ARTICLE => true ];

	public abstract function getFeedTitle();

	public abstract function getFeedLanguage();

	public abstract function getFeedDescription();

	public abstract function getFeedData();

	public abstract function getModelUrlEndpoint();

	/**
	 * @param $feedName
	 * @return BaseRssModel
	 */
	public static function newFromName( $feedName ) {
		switch ( strtolower( $feedName ) ) {
			case self::GAMES_FEED:
				return new GamesRssModel();
			case self::TV_FEED:
				return new TvRssModel();
		}
	}

	/**
	 * @param boolean $forceRegenerateFeed
	 */
	public function setForceRegenerateFeed( $forceRegenerateFeed ) {
		$this->forceRegenerateFeed = $forceRegenerateFeed;
	}

	protected function getDbSlave() {
		static $db = null;
		if ( $db === null ) {
			global $wgExternalDatawareDB;
			$db = wfGetDB( DB_SLAVE, null, $wgExternalDatawareDB );
		}
		return $db;
	}

	protected function getDbMaster() {
		static $db = null;
		if ( $db === null ) {
			global $wgExternalDatawareDB;
			$db = wfGetDB( DB_MASTER, null, $wgExternalDatawareDB );
		}
		return $db;
	}

	protected function addFeedsToDb( $rows, $feed ) {
		$db = $this->getDbMaster();
		$db->begin();
		$nowDate = date('Y-m-d H:i:s');
		foreach ( $rows as $url => $item ) {
			( new WikiaSQL() )
				->INSERT( 'wikia_rss_feeds' )
				->SET( 'wrf_wikia_id', $item[ 'wikia_id' ] )
				->SET( 'wrf_page_id', $item[ 'page_id' ] )
				->SET( 'wrf_url', $url )
				->SET( 'wrf_feed', $feed )
				->SET( 'wrf_pub_date', date( 'Y-m-d H:i:s', $item[ 'timestamp' ] ) )
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
	}

	protected function isFreshContentInDb( $feed, $hours = self::FRESH_CONTENT_TTL_HOURS ) {
		//select count(1) as c from wikia_rss_feeds where wrf_pub_date >= '2014-05-20 00:00:00' AND wrf_feed = 'tv';

		$startTime = date( 'Y-m-d H:i:s', strtotime( sprintf( 'now - %uhour', $hours ) ) );
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

	protected function getLastRecoredsFromDb( $feed, $limit = self::ROWS_LIMIT, $useMaster = false ) {
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
		$fromTime = date( 'Y-m-d H:i:s', strtotime( sprintf( 'now - %uhour', $maxHours ) ) );
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

	protected function getArticleDetail( $wikiId, $articleId ) {
		$host = WikiFactory::DBtoUrl( WikiFactory::IDtoDB( $wikiId ) );
		$url = sprintf( '%sapi/v1/Articles/Details?ids=%u', $host, $articleId );
		$res = Http::get( $url );
		$res = json_decode( $res, true );
		$article = $res[ 'items' ][ $articleId ];
		if ( !$article[ 'thumbnail' ] ) {
			$ws = new WikiService();
			$article[ 'thumbnail' ] = $ws->getWikiWordmark( $wikiId );
		}
		return [ 'img' => [
			'url' => $article[ 'thumbnail' ],
			'width' => $article[ 'original_dimensions' ][ 'width' ] < self::MIN_IMAGE_SIZE ? self::MIN_IMAGE_SIZE : $article[ 'original_dimensions' ][ 'width' ],
			'height' => $article[ 'original_dimensions' ][ 'height' ] < self::MIN_IMAGE_SIZE ? self::MIN_IMAGE_SIZE : $article[ 'original_dimensions' ][ 'width' ]
		],
			'title' => $article[ 'title' ]
		];
	}

	protected function getArticleDescription( $wikiId, $articleId ) {
		$host = WikiFactory::DBtoUrl( WikiFactory::IDtoDB( $wikiId ) );
		$url = sprintf( '%sapi/v1/Articles/AsSimpleJson?id=%u', $host, $articleId );
		$res = Http::get( $url );
		$res = json_decode( $res, true );
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

			$details = $this->getArticleDetail( $item[ 'wikia_id' ], $item[ 'page_id' ] );
			$item[ 'img' ] = $details[ 'img' ];
			if ( empty( $item[ 'description' ] ) ) {
				$item[ 'description' ] = $this->getArticleDescription( $item[ 'wikia_id' ], $item[ 'page_id' ] );;
			}
			if ( empty( $item[ 'title' ] ) ) {
				$item[ 'title' ] = $details[ 'title' ];
			}

			if ( !$item[ 'timestamp' ] ) {
				$item[ 'timestamp' ] = $time;
			}

			$item = $this->formatTitle( $item );

			$out[ $item[ 'url' ] ] = $item;
		}
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
		//TODO:Fix calculations here!
		foreach ( $wikis as $wid ) {
			$numberOfItemsToAdd[ $wid ] = $perWiki;
		}

		foreach ( $wikis as $wid ) {
			$list = $model->getArticles( $wid );
			foreach ( $list as $item ) {
				if ( !array_key_exists( $item[ 'url' ], $duplicates ) ) {
					$item[ 'source' ]  = self::SOURCE_GENERATOR;
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
		$model = new HubRssFeedModel( $this->getFeedLanguage() );
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
		$out =  $this->findIdForUrls( $hubData , self::SOURCE_HUB );
		return $out;
	}

	protected function findIdForUrls( $urls, $source = null) {
		$data = [ ];
		if ( !empty( $urls ) ) {
			$f2 = new \Wikia\Search\Services\FeedEntitySearchService();
			$f2->setUrls( array_keys( $urls ) );
			$res = $f2->query( '' );
			foreach ( $res as $item ) {

				$item[ 'wikia_id' ] = $item[ 'wid' ];
				$item[ 'page_id' ] = $item[ 'pageid' ];
				if( $source ) {
					$item[ 'source' ] = $source;
				}

				if ( array_key_exists( $item[ 'url' ], $urls ) ) {
					$orgItem = $urls[ $item[ 'url' ] ];
					if ( $orgItem[ 'title' ] ) {
						$item[ 'title' ] = $orgItem[ 'title' ];
					}
					if ( $orgItem[ 'description' ] ) {
						$item[ 'description' ] = $orgItem[ 'description' ];
					}
				}

				$data[ $item[ 'url' ] ] = $item;
			}
		}
		return $data;
	}

	protected function finalizeRecords( $rawData, $rowsToReturn, $feedName ){
		$out = $this->processItems( $rawData );
		$this->addFeedsToDb( $out, $feedName);
		$out = $this->getLastRecoredsFromDb( $feedName, $rowsToReturn, true );
		return $out;
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

}
