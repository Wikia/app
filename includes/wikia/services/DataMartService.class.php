<?php
/*
 * DataMart Service
 */

use FluentSql\StaticSQL as sql;
use Wikia\Logger\WikiaLogger;

class DataMartService extends Service {

	const PERIOD_ID_DAILY = 1;
	const PERIOD_ID_WEEKLY = 2;
	const PERIOD_ID_MONTHLY = 3;
	const PERIOD_ID_QUARTERLY = 4;
	const PERIOD_ID_YEARLY = 5;
	const PERIOD_ID_15MINS = 15;
	const PERIOD_ID_60MINS = 60;
	const PERIOD_ID_ROLLING_7DAYS = 1007; // every day
	const PERIOD_ID_ROLLING_28DAYS = 1028; // every day
	const PERIOD_ID_ROLLING_24HOURS = 10024; // every 15 minutes
	const CACHE_TOP_ARTICLES = 86400;
	const LOCK_TOP_ARTICLES = 10;

	const TOP_WIKIS_FOR_HUB = 10;
	const DEFAULT_TOP_WIKIAS_LIMIT = 200;

	const TTL = 43200; // WikiaSQL results caching time (12 hours)

	/**
	 * Get pageviews
	 *
	 * @param integer $periodId
	 * @param string $startDate [YYYY-MM-DD]
	 * @param string $endDate [YYYY-MM-DD]
	 * @param integer $wikiId
	 *
	 * @return array $pageviews [ array( 'YYYY-MM-DD' => pageviews ) ]
	 */
	protected static function getPageviews ( $periodId, $startDate, $endDate = null, $wikiId = null ) {
		$app = F::app();

		if ( empty( $wikiId ) ) {
			$wikiId = $app->wg->CityId;
		}

		if ( empty( $endDate ) ) {
			if ( $periodId == self::PERIOD_ID_MONTHLY ) {
				$endDate = date( 'Y-m-01' );
			} else {
				$endDate = date( 'Y-m-d', strtotime( '-1 day' ) );
			}
		}

		$db = DataMartService::getDB();
		$pageViews = ( new WikiaSQL() )->skipIf( self::isDisabled() )
			->cacheGlobal( self::TTL )
			->SELECT( "date_format(time_id,'%Y-%m-%d')" )->AS_( 'date' )
				->FIELD( 'pageviews' )->AS_( 'cnt' )
			->FROM( 'rollup_wiki_pageviews' )
			->WHERE( 'period_id' )->EQUAL_TO( $periodId )
				->AND_( 'wiki_id' )->EQUAL_TO( $wikiId )
				->AND_( 'time_id' )->BETWEEN( $startDate, $endDate )
			->runLoop( $db, function ( &$pageViews, $row ) {
				$pageViews[$row->date] = $row->cnt;
			} );

		return $pageViews;
	}

	/**
	 * get pageviews for list of Wikis
	 * @param integer $periodId
	 * @param array $wikis
	 * @param string $startDate [YYYY-MM-DD]
	 * @param string $endDate [YYYY-MM-DD]
	 * @return array $pageviews [ array( 'WIKI_ID' => array( 'YYYY-MM-DD' => pageviews, 'SUM' => sum(pageviews) ) ) ]
	 */
	protected static function getPageviewsForWikis ( $periodId, $wikis, $startDate, $endDate = null ) {
		if ( empty( $wikis ) ) {
			return array();
		}

		if ( empty( $endDate ) ) {
			if ( $periodId == self::PERIOD_ID_MONTHLY ) {
				$endDate = date( 'Y-m-01' );
			} else {
				$endDate = date( 'Y-m-d', strtotime( '-1 day' ) );
			}
		}

		$db = DataMartService::getDB();
		$pageviews = ( new WikiaSQL() )->skipIf( self::isDisabled() )
			->cacheGlobal( self::TTL )
			->SELECT( 'wiki_id' )
				->FIELD( "date_format(time_id,'%Y-%m-%d')" )->AS_( 'date' )
				->FIELD( 'pageviews' )->AS_( 'cnt' )
			->FROM( 'rollup_wiki_pageviews' )
			->WHERE( 'period_id' )->EQUAL_TO( $periodId )
				->AND_( 'wiki_id' )->IN( $wikis )
				->AND_( 'time_id' )->BETWEEN( $startDate, $endDate )
			->runLoop( $db, function ( &$pageViews, $row ) {
				$pageViews[$row->wiki_id][$row->date] = $row->cnt;
				$pageViews[$row->wiki_id]['SUM'] += $row->cnt;
			} );

		return $pageviews;
	}

	/**
	 * get pageviews
	 * @param array $dates ( YYYY-MM-DD, YYYY-MM-DD ... )
	 * @return array $pageviews [ array( 'YYYY-MM-DD' => pageviews ) ]
	 */
	public static function getSumPageviewsMonthly ( $dates = array() ) {
		$periodId = self::PERIOD_ID_MONTHLY;

		if ( empty( $dates ) ) {
			return array();
		}

		$db = DataMartService::getDB();
		$pageviews = ( new WikiaSQL() )->skipIf( self::isDisabled() )
			->cacheGlobal( self::TTL )
			->SELECT( 'time_id' )
				->SUM( 'pageviews' )->AS_( 'cnt' )
			->FROM( 'rollup_wiki_pageviews' )
			->WHERE( 'period_id' )->EQUAL_TO( $periodId )
				->AND_( 'time_id' )->IN( $dates )
			->runLoop( $db, function( &$pageViews, $row ) {
				$pageViews[$row->time_id] = intval( $row->cnt );
			} );

		return $pageviews;
	}

	// get daily pageviews
	public static function getPageviewsDaily ( $startDate, $endDate = null, $wiki = null ) {
		if ( is_array( $wiki ) ) {
			$pageViews = self::getPageviewsForWikis( self::PERIOD_ID_DAILY, /* array of Wikis */
				$wiki, $startDate, $endDate );
		} else {
			$pageViews = self::getPageviews( self::PERIOD_ID_DAILY, $startDate, $endDate, /* ID */
				$wiki );
		}

		return $pageViews;
	}

	// get weekly pageviews
	public static function getPageviewsWeekly ( $startDate, $endDate = null, $wiki = null ) {
		if ( is_array( $wiki ) ) {
			$pageviews = self::getPageviewsForWikis( self::PERIOD_ID_WEEKLY, /* array of Wikis */
				$wiki, $startDate, $endDate );
		} else {
			$pageviews = self::getPageviews( self::PERIOD_ID_WEEKLY, $startDate, $endDate, /* ID */
				$wiki );
		}

		return $pageviews;
	}

	// get monthly pageviews
	public static function getPageviewsMonthly ( $startDate, $endDate = null, $wiki = null ) {
		if ( is_array( $wiki ) ) {
			$pageviews = self::getPageviewsForWikis( self::PERIOD_ID_MONTHLY, /* array of Wikis */
				$wiki, $startDate, $endDate );
		} else {
			$pageviews = self::getPageviews( self::PERIOD_ID_MONTHLY, $startDate, $endDate, /* ID */
				$wiki );
		}

		return $pageviews;
	}

	/**
	 * Get top wikis by pageviews over a specified span of time, optionally filtering by
	 * public status, language and vertical (hub)
	 *
	 * @param integer $periodId The interval of time to take into consideration, one of PERIOD_ID_WEEKLY,
	 * PERIOD_ID_MONTHLY or PERIOD_ID_QUARTERLY
	 * @param integer $limit The maximum number of results, defaults to 200
	 * @param array $langs (optional) The language code to use as a filter (e.g. en for English), null for all (default)
	 * @param string $hub (optional) The vertical name to use as a filter (e.g. Gaming), null for all (default)
	 * @param integer $public (optional) Filter results by public status, one of 0, 1 or null (for both, default)
	 * @return array $topWikis [ array( wikiId => pageviews ) ]
	 */
	public static function getTopWikisByPageviews ( $periodId, $limit = 200, Array $langs = [], $hub = null, $public = null ) {
		$limitDefault = 200;
		$limitUsed = ( $limit > $limitDefault ) ? $limit : $limitDefault;

		switch ( $periodId ) {
			case self::PERIOD_ID_WEEKLY:
				$field = 'pageviews_7day';
				break;
			case self::PERIOD_ID_QUARTERLY:
				$field = 'pageviews_90day';
				break;
			case self::PERIOD_ID_MONTHLY:
			default:
				$field = 'pageviews_30day';
				break;
		}

		$db = DataMartService::getDB();

		$sql = ( new WikiaSQL() )->skipIf( self::isDisabled() )
			->cacheGlobal( self::TTL )
			->SELECT( 'r.wiki_id' )->AS_( 'id' )
				->FIELD( $field )->AS_( 'pageviews' )
			->FROM( 'report_wiki_recent_pageviews' )->AS_( 'r' )
			->ORDER_BY( ['pageviews', 'desc'] )
			->LIMIT( $limitUsed );

		if ( is_integer( $public ) ) {
			$sql
				->JOIN( 'dimension_wikis' )->AS_( 'd' )
					->ON( 'r.wiki_id', 'd.wiki_id' )
				->WHERE( 'd.public' )->EQUAL_TO( $public );
		}

		if ( !empty( $langs ) ) {
			$sql->AND_( 'r.lang' )->IN( $langs );
		}

		if ( !empty( $hub ) ) {
			$sql->AND_( 'r.hub_name' )->EQUAL_TO( $hub );
		}

		$topWikis = $sql->runLoop( $db, function( &$topWikis, $row ) {
			$topWikis[$row->id] = $row->pageviews;
		} );

		$topWikis = array_slice( $topWikis, 0, $limit, true );

		return $topWikis;
	}

	/**
	 * Get top wikis by videoviews over a specified span of time, optionally filtering by
	 * public status
	 *
	 * @param integer $periodId The interval of time to take into consideration, one of PERIOD_ID_WEEKLY,
	 * PERIOD_ID_MONTHLY or PERIOD_ID_QUARTERLY
	 * @param integer $lastN The last N periods to sum results for
	 * @param integer $limit The maximum number of results, defaults to 200
	 * @return array $topWikis [ array( wikiId => videoviews ) ]
	 */
	public static function getTopWikisByVideoviews ( $periodId, $lastN, $limit = 200 ) {
		$db = DataMartService::getDB();

		$topWikis = ( new WikiaSQL() )->skipIf( self::isDisabled() )
			->cacheGlobal( self::TTL )
			->SELECT( 'r.wiki_id' )->AS_( 'id' )
				->SUM( 'views' )->AS_( 'totalViews' )
			->FROM( 'rollup_wiki_video_views' )->AS_( 'r' )
			->WHERE( 'period_id' )->EQUAL_TO( $periodId )
				->AND_( 'time_id' )->GREATER_THAN( sql::NOW()->MINUS_INTERVAL( $lastN, 'day' ) )
			->GROUP_BY( 'id' )
			->ORDER_BY( ['totalViews', 'desc'] )
			->LIMIT( 200 )
			->runLoop( $db, function( &$topWikis, $row ) {
				$topWikis[$row->id] = $row->totalViews;
			} );

		$topWikis = array_slice( $topWikis, 0, $limit, true );

		return $topWikis;
	}

	/**
	 * get events by wiki Id
	 * @param integer $periodId
	 * @param string $startDate [YYYY-MM-DD]
	 * @param string $endDate [YYYY-MM-DD]
	 * @param integer $wikiId
	 * @param string $eventType [creates/edits/deletes/undeletes]
	 * @return array $events [ array( 'YYYY-MM-DD' => pageviews ) ]
	 * Note: number of edits includes number of creates
	 */
	protected static function getEventsByWikiId ( $periodId, $startDate, $endDate = null, $wikiId = null, $eventType = null ) {
		$app = F::app();

		wfProfileIn( __METHOD__ );

		if ( empty( $wikiId ) ) {
			$wikiId = $app->wg->CityId;
		}

		if ( empty( $endDate ) ) {
			if ( $periodId == self::PERIOD_ID_MONTHLY ) {
				$endDate = date( 'Y-m-01' );
			} else {
				$endDate = date( 'Y-m-d', strtotime( '-1 day' ) );
			}
		}

		$db = DataMartService::getDB();
		$events = ( new WikiaSQL() )->skipIf( self::isDisabled() )
			->cacheGlobal( self::TTL )
			->SELECT( "date_format(time_id,'%Y-%m-%d')" )->AS_( 'date' )
				->SUM( 'creates' )->AS_( 'creates' )
				->SUM( 'edits' )->AS_( 'edits' )
				->SUM( 'deletes' )->AS_( 'deletes' )
				->SUM( 'undeletes' )->AS_( 'undeletes' )
			->FROM( 'rollup_wiki_namespace_user_events' )
			->WHERE( 'period_id' )->EQUAL_TO( $periodId )
				->AND_( 'wiki_id' )->EQUAL_TO( $wikiId )
				->AND_( 'time_id' )->BETWEEN( $startDate, $endDate )
			->GROUP_BY( 'date', 'wiki_id' )
			->runLoop( $db, function( &$events, $row ) {
				$events[$row->date] = array(
					'creates' => $row->creates,
					'edits' => $row->creates + $row->edits,
					'deletes' => $row->deletes,
					'undeletes' => $row->undeletes,
				);
			} );

		// get data depending on eventType
		if ( !empty( $eventType ) ) {
			$temp = array();
			foreach ( $events as $date => $value ) {
				$temp[$date] = $value[$eventType];
			}
			$events = $temp;
		}

		wfProfileOut( __METHOD__ );

		return $events;
	}

	/**
	 * Gets user edits by user and wiki id
	 * It will be used in WAM and Interstitials
	 * @param integer|array $userIds
	 * @param integer $wikiId
	 * @return array $events [ array( 'user_id' => array() ) ]
	 * Note: number of edits includes number of creates
	 */
	public static function getUserEditsByWikiId ( $userIds, $wikiId = null ) {
		$app = F::app();
		$periodId = self::PERIOD_ID_WEEKLY;
		// Every weekly rollup is made on Sundays. We need date of penultimate Sunday.
		// We dont get penultimate date of rollup from database, becasuse of performance issue
		$rollupDate = date( "Y-m-d", strtotime( "Sunday 1 week ago" ) );

		wfProfileIn( __METHOD__ );

		if ( empty( $userIds ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( empty( $wikiId ) ) {
			$wikiId = $app->wg->CityId;
		}

		// this is made because memcache key has character limit and a long
		// list of user ids can be passed so we need to have it shorter
		$userIdsKey = self::makeUserIdsMemCacheKey( $userIds );

		$events = WikiaDataAccess::cacheWithLock(
			wfSharedMemcKey( 'datamart', 'user_edits', $wikiId, $userIdsKey, $periodId, $rollupDate ),
			86400 /* 24 hours */,
			function () use ( $app, $wikiId, $userIds, $periodId, $rollupDate ) {
				$db = DataMartService::getDB();
				$events = ( new WikiaSQL() )->skipIf( self::isDisabled() )
					->SELECT( 'user_id' )
						->SUM( 'creates' )->AS_( 'creates' )
						->SUM( 'edits' )->AS_( 'edits' )
						->SUM( 'deletes' )->AS_( 'deletes' )
						->SUM( 'undeletes' )->AS_( 'undeletes' )
					->FROM( 'rollup_wiki_namespace_user_events' )
					->WHERE( 'period_id' )->EQUAL_TO( $periodId )
						->AND_( 'wiki_id' )->EQUAL_TO( $wikiId )
						->AND_( 'time_id' )->EQUAL_TO( $rollupDate )
						->AND_( 'user_id' )->IN( $userIds )
					->GROUP_BY( 'user_id' )
					->runLoop( $db, function( &$events, $row ) {
						$events[$row->user_id] = [
							'creates' => $row->creates,
							'edits' => $row->creates + $row->edits,
							'deletes' => $row->deletes,
							'undeletes' => $row->undeletes,
						];
					} );

				return $events;
			}
		);

		wfProfileOut( __METHOD__ );

		return $events;
	}

	private static function makeUserIdsMemCacheKey( $userIds ) {
		$idsKey = md5( implode( ',', $userIds ) );
		return $idsKey;
	}

	// get daily edits
	public static function getEditsDaily ( $startDate, $endDate = null, $wikiId = null ) {
		$edits = self::getEventsByWikiId( self::PERIOD_ID_DAILY, $startDate, $endDate, $wikiId, 'edits' );

		return $edits;
	}

	// get weekly edits
	public static function getEditsWeekly ( $startDate, $endDate = null, $wikiId = null ) {
		$edits = self::getEventsByWikiId( self::PERIOD_ID_WEEKLY, $startDate, $endDate, $wikiId, 'edits' );

		return $edits;
	}

	// get monthly edits
	public static function getEditsMonthly ( $startDate, $endDate = null, $wikiId = null ) {
		$edits = self::getEventsByWikiId( self::PERIOD_ID_MONTHLY, $startDate, $endDate, $wikiId, 'edits' );

		return $edits;
	}

	public static function findLastRollupsDate( $period_id, $numTry = 5 ) {
		$db = DataMartService::getDB();
		// compensation for NOW
		$date = date( 'Y-m-d' ) . ' 00:00:01';
		do {
			$date = ( new WikiaSQL() )->skipIf( self::isDisabled() )
				->SELECT( 'time_id as t' )
				->FROM( 'rollup_wiki_article_pageviews' )
				->WHERE( 'time_id' )->LESS_THAN( $date )
				->ORDER_BY( 'time_id' )->DESC()
				->LIMIT( 1 )
				->cache( self::CACHE_TOP_ARTICLES )
				->run( $db, function ( ResultWrapper $result ) {
					$row = $result->fetchObject();

					if ( $row && isset( $row->t ) ) {
						return $row->t;
					}

					return null;
				} );
			if ( !$date ) {
				break;
			}

			$found =  ( new WikiaSQL() )->skipIf( self::isDisabled() )
				->SELECT( '1 as c' )
				->FROM( 'rollup_wiki_article_pageviews' )
				->WHERE( 'time_id' )->EQUAL_TO( $date )
				->AND_( 'period_id' )->EQUAL_TO( $period_id )
				->LIMIT( 1 )
				->cache( self::CACHE_TOP_ARTICLES )
				->run( $db, function ( ResultWrapper $result ) {
					$row = $result->fetchObject();

					if ( $row && isset( $row->c ) ) {
						return $row->c;
					}

					return null;
				} );

			$numTry--;
		} while ( !$found &&  $numTry > 0 );
		return $date;
	}

	/**
	 * Gets the list of top articles for a wiki on a weekly pageviews basis
	 *
	 * @param integer $wikiId A valid Wiki ID to fetch the list from
	 * @param Array $articleIds [OPTIONAL] A list of article ID's to restrict the list
	 * @param Array $namespaces [OPTIONAL] A list of namespace ID's to restrict the list (inclusive)
	 * @param boolean $excludeNamespaces [OPTIONAL] Sets $namespaces as an exclusive list, defaults to false
	 * @param integer $limit [OPTIONAL] The maximum number of items in the list, defaults to 200
	 * @param integer $rollupDate [OPTIONAL] Rollup ID to get (instead of the recent one)
	 *
	 * @return Array The list, the key contains article ID's and each item as a "namespace_id" and "pageviews" key
	 */
	private static function doGetTopArticlesByPageview(
		$wikiId,
		Array $articleIds = null,
		Array $namespaces = null,
		$excludeNamespaces = false,
		$limit = 200,
		$rollupDate = null
	) {
		$app = F::app();

		$cacheVersion = 4;
		$limitDefault = 200;
		$limitUsed = ( $limit > $limitDefault ) ? $limit : $limitDefault ;
		$keyToken = '';

		if ( !empty( $namespaces ) && is_array( $namespaces ) ) {
			$keyToken .= implode( ':', $namespaces );
		} else {
			$namespaces = null;
		}

		if ( !empty( $articleIds ) && is_array( $articleIds ) ) {
			$keyToken .= implode( ':', $articleIds );
		} else {
			$articleIds = null;
		}

		$memKey = wfSharedMemcKey(
			'datamart',
			'toparticles',
			$cacheVersion,
			$wikiId,
			$limitUsed,
			( $keyToken !== '' ) ? md5( $keyToken ) : null,
			$excludeNamespaces,
			$rollupDate ? $rollupDate : 'current'
		);

		$getData = function() use ( $app, $wikiId, $namespaces, $excludeNamespaces, $articleIds, $limitUsed, $rollupDate ) {

			/*
			the rollup_wiki_article_pageviews contains only summarized data
			with the time_id of last sunday, so fetch just that one as
			the table is partitioned on a per-day basis and crossing
			multiple partitions kills kittens
			*/

			$db = DataMartService::getDB();
			$sql = ( new WikiaSQL() )->skipIf( self::isDisabled() )
				->SELECT( 'namespace_id', 'article_id', 'pageviews as pv' )
				->FROM( 'rollup_wiki_article_pageviews' )
				->WHERE( 'time_id' )->EQUAL_TO(
						$rollupDate ? $rollupDate : sql::RAW( 'CURDATE() - INTERVAL DAYOFWEEK(CURDATE()) - 1 DAY' )
					)
					->AND_( 'period_id' )->EQUAL_TO( DataMartService::PERIOD_ID_WEEKLY )
					->AND_( 'wiki_id' )->EQUAL_TO( $wikiId )
				->ORDER_BY( ['pv', 'desc'] )
				->LIMIT( $limitUsed );

			if ( !empty( $namespaces ) ) {
				$namespaces = array_filter( $namespaces, function( $val ) {
					return is_integer( $val );
				} );

				$sql->AND_( 'namespace_id' );

				if ( !empty( $excludeNamespaces ) ) {
					$sql->NOT_IN( $namespaces );
				} else {
					$sql->IN( $namespaces );
				}
			}

			if ( !empty( $articleIds ) ) {
				$articleIds = array_filter( $articleIds, function( $val ) {
					return is_integer( $val );
				} );

				$sql->AND_( 'article_id' )->IN( $articleIds );
			}

			$topArticles = $sql->runLoop( $db, function( &$topArticles, $row ) {
				$topArticles[$row->article_id] = [
					'namespace_id' => $row->namespace_id,
					'pageviews' => $row->pv
				];
			} );

			return $topArticles;
		};

		$topArticles = WikiaDataAccess::cacheWithLock(
			$memKey,
			self::CACHE_TOP_ARTICLES,
			$getData,
			WikiaDataAccess::USE_CACHE,
			self::LOCK_TOP_ARTICLES
		);

		$topArticles = array_slice( $topArticles, 0, $limit, true );

		return $topArticles;
	}

	/**
	 * Gets the list of top articles for a wiki on a weekly pageviews basis
	 *
	 * It internally calls doGetTopArticlesByPageview() method,
	 * but applies a fallback to the last rollup when the current one is not replicated
	 *
	 * It's A Nasty And Ugly Hack (TM) before we have a proper rollups solution.
	 *
	 * @see https://wikia-inc.atlassian.net/browse/OPS-5465
	 *
	 * @param integer $wikiId A valid Wiki ID to fetch the list from
	 * @param Array $articleIds [OPTIONAL] A list of article ID's to restrict the list
	 * @param Array $namespaces [OPTIONAL] A list of namespace ID's to restrict the list (inclusive)
	 * @param boolean $excludeNamespaces [OPTIONAL] Sets $namespaces as an exclusive list, defaults to false
	 * @param integer $limit [OPTIONAL] The maximum number of items in the list, defaults to 200
	 * @param integer $rollupDate [OPTIONAL] Rollup ID to get (instead of the recent one)
	 *
	 * @return Array The list, the key contains article ID's and each item as a "namespace_id" and "pageviews" key
	 */
	public static function getTopArticlesByPageview(
		$wikiId,
 		Array $articleIds = null,
		Array $namespaces = null,
		$excludeNamespaces = false,
		$limit = 200,
		$rollupDate = null
	) {
		$articles = self::doGetTopArticlesByPageview(
			$wikiId,
			$articleIds,
			$namespaces,
			$excludeNamespaces,
			$limit,
			$rollupDate
		);

		if ( empty( $articles ) ) {
			// log when the fallback takes place
			WikiaLogger::instance()->error( __METHOD__ . ' fallback', [
				'wiki_id' => $wikiId,
				'rollup_date' => $rollupDate
			] );

			$fallbackDate = self::findLastRollupsDate( self::PERIOD_ID_WEEKLY );
			if ( $fallbackDate ) {
				$articles = self::doGetTopArticlesByPageview(
					$wikiId,
					$articleIds,
					$namespaces,
					$excludeNamespaces,
					$limit,
					$fallbackDate
				);
			}
		}

		return $articles;
	}

	/**
	 * Get most popular cross wiki articles based on pageviews in last week.
	 * Unfortunately according to performance reasons we need to fetch most popular wikis
	 * and then fetch most popular articles on those wikis.
	 *
	 * @param string $hub
	 * @param string $langs
	 * @param array|null $namespaces
	 * @param int $limit
	 * @return array of wikis with articles. Format:
	 * [
	 *   [
	 *     'wiki' => [
	 *       'id' => 1030786,
	 *       'name' => 'Wiki name',
	 *       'language' => 'language code',
	 *       'domain' => 'Full url',
	 *     ],
	 *     'articles' => [
	 *        ['id' => 1, 'ns' => 0],
	 *        ['id' => 2, 'ns' => -1]
	 *      ]
	 *   ],
	 *   [
	 *     'wiki' => [
	 *       'id' => 1030786,
	 *       'name' => 'Wiki name',
	 *       'language' => 'language code',
	 *       'domain' => 'Full url',
	 *     ],
	 *     'articles' => [
	 *        ['id' => 1, 'ns' => 0],
	 *        ['id' => 2, 'ns' => -1]
	 *      ]
	 *   ],
	 * ]
	 */
	public static function getTopCrossWikiArticlesByPageview( $hub, $langs, $namespaces = null, $limit = 200 ) {
		// fetch the top 10 wikis on a weekly pageviews basis
		// this has it's own cache
		$wikis = DataMartService::getTopWikisByPageviews(
			DataMartService::PERIOD_ID_WEEKLY,
			self::TOP_WIKIS_FOR_HUB,
			$langs,
			$hub,
			1 /* only pubic */
		);

		$wikisCount = count( $wikis );
		$res = [];

		if ( $wikisCount >= 1 ) {
			$articlesPerWiki = ceil( $limit / $wikisCount );

			// fetch $articlesPerWiki articles from each wiki
			// see FB#73094 for performance review
			foreach ( $wikis as $wikiId => $data ) {
				// this has it's own cache
				$articles = DataMartService::getTopArticlesByPageview(
					$wikiId,
					null,
					$namespaces,
					false,
					$articlesPerWiki
				);

				if ( count( $articles ) == 0 ) {
					continue;
				}

				$item = [
					'wiki' => [
						'id' => $wikiId,
						// WF data has it's own cache
						'name' => WikiFactory::getVarValueByName( 'wgSitename', $wikiId ),
						'language' => WikiFactory::getVarValueByName( 'wgLanguageCode', $wikiId ),
						'domain' => WikiFactory::getVarValueByName( 'wgServer', $wikiId )
					],
					'articles' => []
				];

				foreach ( $articles as $articleId => $article ) {
					$item['articles'][] = [
						'id' => $articleId,
						'ns' => $article['namespace_id']
					];
				}

				$res[] = $item;
			}
		}

		return $res;
	}

	/**
	 * Gets the list of top wikis for tag_id and language on a monthly pageviews basis
	 *
	 * @param integer $tagId A valid tag_id from city_tag_map table
	 * @param string $startDate [YYYY-MM-DD]
	 * @param string $endDate [YYYY-MM-DD]
	 * @param string $langCode A valid Wiki's language code
	 * @param integer $periodId
	 * @param integer $limit [OPTIONAL] The maximum number of items in the list, defaults to 200
	 *
	 * @return Array The list, the key contains Wiki ID's and "pageviews" number
	 */
	public static function getTopTagsWikisByPageviews ( $tagId, $startDate, $endDate, $langCode = 'en', $periodId = null, $limit = 200 ) {
		$app = F::app();

		if ( empty( $endDate ) ) {
			if ( $periodId == self::PERIOD_ID_MONTHLY ) {
				$endDate = date( 'Y-m-01' );
			} else {
				$endDate = date( 'Y-m-d', strtotime( '-1 day' ) );
			}

		}

		if ( empty( $periodId ) ) {
			$periodId = self::PERIOD_ID_MONTHLY;
		}

		$memKey = wfSharedMemcKey( 'datamart', 'tags_top_wikis', $tagId, $periodId, $startDate, $endDate, $langCode, $limit );
		$tagViews = $app->wg->Memc->get( $memKey );
		if ( !is_array( $tagViews ) ) {
			$tagViews = array();
			if ( !self::isDisabled() ) {
				$db = DataMartService::getDB();

				$tables = array(
					'r' => 'rollup_wiki_pageviews',
					'c' => 'wikicities.city_tag_map',
					'd' => 'dimension_wikis'
				);
				$fields = array(
					'c.tag_id as tag_id',
					'r.wiki_id',
					'sum(r.pageviews) as pviews'
				);
				$cond = array(
					'period_id' => $periodId,
					'tag_id' => $tagId,
					"time_id between '{$startDate}' AND '{$endDate}'",
				);
				$opts = array(
					'GROUP BY' => 'c.tag_id, r.wiki_id',
					'ORDER BY' => 'pviews DESC',
					'LIMIT' => $limit
				);
				$join_conds = array(
					'c' => array( 'INNER JOIN', array( 'c.city_id = r.wiki_id' ) ),
					'd' => array( 'INNER JOIN', array( 'd.wiki_id = r.wiki_id', 'd.public = 1', "d.lang = '{$langCode}'" ) )
				);

				$result = $db->select( $tables, $fields, $cond, __METHOD__, $opts, $join_conds );

				while ( $row = $db->fetchObject( $result ) ) {
					$tagViews[$row->wiki_id] = $row->pviews;
				}

				$app->wg->Memc->set( $memKey, $tagViews, 60 * 60 * 12 );
			}
		}

		return $tagViews;
	}

	/**
	 * Gets page views for given articles
	 *
	 * @param array $articlesIds
	 * @param datetime $timeId
	 * @return array
	 */
	public static function getPageViewsForArticles( Array $articlesIds, $timeId, $wikiId, $periodId = self::PERIOD_ID_WEEKLY ) {
		$db = DataMartService::getDB();

		$articlePageViews = ( new WikiaSQL() )->skipIf( self::isDisabled() )
			->SELECT( 'article_id', 'pageviews' )
			->FROM( 'rollup_wiki_article_pageviews' )
			->WHERE( 'article_id' )->IN( $articlesIds )
			->AND_( 'time_id' )->EQUAL_TO( $timeId )
			->AND_( 'wiki_id' )->EQUAL_TO( intval( $wikiId ) )
			->AND_( 'period_id' )->EQUAL_TO( intval( $periodId ) )
			->runLoop( $db, function( &$articlePageViews, $row ) {
				$articlePageViews[ $row->article_id ] = $row->pageviews;
			} );

		return $articlePageViews;
	}

	public static function getWAM200Wikis() {
		$db = DataMartService::getDB();

		$wikis = ( new WikiaSQL() )->skipIf( self::isDisabled() )
			->cacheGlobal( self::TTL )
			->SELECT( 'wiki_id' )
			->FROM( 'dimension_top_wikis' )
			->ORDER_BY( 'rank' )
			->LIMIT( 200 )
			->runLoop( $db, function( &$wikis, $row ) {
				$wikis[] = intval( $row->wiki_id );
			} );

		return $wikis;
	}

	/**
	 * Returns an array of IDs of wikias ordered by WAM rank.
	 * The default limit is 200. If 0 is provided - no limit is used.
	 * @param int $limit Default is set as the DEFAULT_TOP_WIKIAS_LIMIT const
	 * @param array $wikisIds Limit the range to certain wikis
	 * @return bool|array An array of IDs or `false` on no results
	 */
	public function getWikisOrderByWam( $limit = self::DEFAULT_TOP_WIKIAS_LIMIT, array $wikisIds = [] ) {
		$db = DataMartService::getDB();

		$sql = ( new WikiaSQL() )->skipIf( self::isDisabled() )
			->cacheGlobal( self::TTL )
			->SELECT( 'wiki_id' )
			->FROM( 'dimension_top_wikis' )
			->ORDER_BY( 'rank' );

		/**
		 * Limit the results to certain wikias
		 */
		if ( !empty( $wikisIds ) ) {
			$sql->WHERE( 'wiki_id' )->IN( $wikisIds );
		}

		/**
		 * Limit the number of results
		 */
		if ( $limit > 0 ) {
			$sql->LIMIT( (int)$limit );
		}

		$wikis = $sql->runLoop( $db, function( &$wikis, $row ) {
			$wikis[] = (int)$row->wiki_id;
		} );

		return $wikis;
	}

	protected static function getDB() {
		$app = F::app();
		wfGetLB( $app->wg->DWStatsDB )->allowLagged( true );
		$db = wfGetDB( DB_SLAVE, array(), $app->wg->DWStatsDB );
		$db->clearFlag( DBO_TRX );
		return $db;
	}

	/**
	 * wgStatsDBEnabled can be used to disable queries to statsdb_mart database
	 *
	 * @return bool
	 */
	protected static function isDisabled() {
		return empty( F::app()->wg->StatsDBEnabled );
	}

}
