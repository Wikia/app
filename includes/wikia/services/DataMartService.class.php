<?php

/*
 * DataMart Service
 */
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

	/**
	 * get pageviews
	 * @param integer $periodId
	 * @param string $startDate [YYYY-MM-DD]
	 * @param string $endDate [YYYY-MM-DD]
	 * @param integer $wikiId
	 * @return array $pageviews [ array( 'YYYY-MM-DD' => pageviews ) ]
	 */
	protected static function getPageviews ($periodId, $startDate, $endDate = null, $wikiId = null) {
		$app = F::app();

		wfProfileIn(__METHOD__);

		if (empty($wikiId)) {
			$wikiId = $app->wg->CityId;
		}

		if (empty($endDate)) {
			if ($periodId == self::PERIOD_ID_MONTHLY) {
				$endDate = date('Y-m-01');
			} else {
				$endDate = date('Y-m-d', strtotime('-1 day'));
			}
		}

		$memKey = wfSharedMemcKey('datamart', 'pageviews', $wikiId, $periodId, $startDate, $endDate);
		$pageviews = $app->wg->Memc->get($memKey);
		if (!is_array($pageviews)) {
			$pageviews = array();
			if (!empty($app->wg->StatsDBEnabled)) {
				$db = wfGetDB(DB_SLAVE, array(), $app->wg->DatamartDB);

				$result = $db->select(
					array('rollup_wiki_pageviews'),
					array("date_format(time_id,'%Y-%m-%d') as date, pageviews as cnt"),
					array('period_id' => $periodId,
						'wiki_id' => $wikiId,
						"time_id between '$startDate' and '$endDate'"),
					__METHOD__
				);

				while ($row = $db->fetchObject($result)) {
					$pageviews[$row->date] = $row->cnt;
				}

				$app->wg->Memc->set($memKey, $pageviews, 60 * 60 * 12);
			}
		}

		wfProfileOut(__METHOD__);

		return $pageviews;
	}

	/**
	 * get pageviews for list of Wikis
	 * @param integer $periodId
	 * @param array $wikis
	 * @param string $startDate [YYYY-MM-DD]
	 * @param string $endDate [YYYY-MM-DD]
	 * @return array $pageviews [ array( 'WIKI_ID' => array( 'YYYY-MM-DD' => pageviews, 'SUM' => sum(pageviews) ) ) ]
	 */
	protected static function getPageviewsForWikis ($periodId, $wikis, $startDate, $endDate = null) {
		$app = F::app();

		wfProfileIn(__METHOD__);

		if (empty($wikis)) {
			wfProfileOut(__METHOD__);
			return array();
		}

		if (empty($endDate)) {
			if ($periodId == self::PERIOD_ID_MONTHLY) {
				$endDate = date('Y-m-01');
			} else {
				$endDate = date('Y-m-d', strtotime('-1 day'));
			}
		}

		$wkey = md5(implode(":", $wikis));
		$memKey = wfSharedMemcKey('datamart', 'pageviews_wikis', $wkey, $periodId, $startDate, $endDate);
		$pageviews = $app->wg->Memc->get($memKey);
		if (!is_array($pageviews)) {
			$pageviews = array();
			if (!empty($app->wg->StatsDBEnabled)) {
				$db = wfGetDB(DB_SLAVE, array(), $app->wg->DatamartDB);

				$result = $db->select(
					array('rollup_wiki_pageviews'),
					array("wiki_id, date_format(time_id,'%Y-%m-%d') as date, pageviews as cnt"),
					array('period_id' => $periodId,
						'wiki_id' => $wikis,
						"time_id between '$startDate' and '$endDate'"
					),
					__METHOD__
				);

				while ($row = $db->fetchObject($result)) {
					$pageviews[$row->wiki_id][$row->date] = $row->cnt;
					$pageviews[$row->wiki_id]['SUM'] += $row->cnt;
				}

				$app->wg->Memc->set($memKey, $pageviews, 60 * 60 * 12);
			}
		}

		wfProfileOut(__METHOD__);

		return $pageviews;
	}

	/**
	 * get pageviews
	 * @param array $dates ( YYYY-MM-DD, YYYY-MM-DD ... )
	 * @return array $pageviews [ array( 'YYYY-MM-DD' => pageviews ) ]
	 */
	public static function getSumPageviewsMonthly ($dates = array()) {
		$app = F::app();

		wfProfileIn(__METHOD__);
		$periodId = self::PERIOD_ID_MONTHLY;

		if (empty($dates)) {
			wfProfileOut(__METHOD__);
			return array();
		}

		$dkey = md5(implode(":", $dates));
		$memKey = wfSharedMemcKey('datamart', 'sumpageviews', $periodId, $dkey);
		$pageviews = $app->wg->Memc->get($memKey);
		if (!is_array($pageviews)) {
			$pageviews = array();
			if (!empty($app->wg->StatsDBEnabled)) {
				$db = wfGetDB(DB_SLAVE, array(), $app->wg->DatamartDB);

				foreach ($dates as $date) {
					$row = $db->selectRow(
						array('rollup_wiki_pageviews'),
						array("sum(pageviews) as cnt"),
						array(
							'period_id' => $periodId,
							'time_id' => $date
						),
						__METHOD__
					);

					if ($row) {
						$pageviews[$date] = intval($row->cnt);
					}
				}

				$app->wg->Memc->set($memKey, $pageviews, 60 * 60 * 12);
			}
		}

		wfProfileOut(__METHOD__);

		return $pageviews;
	}

	// get daily pageviews
	public static function getPageviewsDaily ($startDate, $endDate = null, $wiki = null) {
		if (is_array($wiki)) {
			$pageviews = self::getPageviewsForWikis(self::PERIOD_ID_DAILY, /* array of Wikis */
				$wiki, $startDate, $endDate);
		} else {
			$pageviews = self::getPageviews(self::PERIOD_ID_DAILY, $startDate, $endDate, /* ID */
				$wiki);
		}

		return $pageviews;
	}

	// get weekly pageviews
	public static function getPageviewsWeekly ($startDate, $endDate = null, $wiki = null) {
		if (is_array($wiki)) {
			$pageviews = self::getPageviewsForWikis(self::PERIOD_ID_WEEKLY, /* array of Wikis */
				$wiki, $startDate, $endDate);
		} else {
			$pageviews = self::getPageviews(self::PERIOD_ID_WEEKLY, $startDate, $endDate, /* ID */
				$wiki);
		}

		return $pageviews;
	}

	// get monthly pageviews
	public static function getPageviewsMonthly ($startDate, $endDate = null, $wiki = null) {
		if (is_array($wiki)) {
			$pageviews = self::getPageviewsForWikis(self::PERIOD_ID_MONTHLY, /* array of Wikis */
				$wiki, $startDate, $endDate);
		} else {
			$pageviews = self::getPageviews(self::PERIOD_ID_MONTHLY, $startDate, $endDate, /* ID */
				$wiki);
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
	 * @param string $lang (optional) The language code to use as a filter (e.g. en for English),
	 * null for all (default)
	 * @param string $hub (optional) The vertical name to use as a filter (e.g. Gaming), null for all (default)
	 * @param integer $public (optional) Filter results by public status, one of 0, 1 or null (for both, default)
	 *
	 * @return array $topWikis [ array( wikiId => pageviews ) ]
	 */
	public static function getTopWikisByPageviews ($periodId, $limit = 200, Array $langs = [], $hub = null, $public = null) {
		$app = F::app();
		wfProfileIn(__METHOD__);

		$cacheVersion = 2;
		$limitDefault = 200;
		$limitUsed = ($limit > $limitDefault) ? $limit : $limitDefault;

		switch ($periodId) {
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

		$memKey = wfSharedMemcKey('datamart', 'topwikis', $cacheVersion, $field, $limitUsed, implode( ',', $langs ), $hub, $public);
		$getData = function () use ($app, $limitUsed, $langs, $hub, $public, $field) {
			wfProfileIn(__CLASS__ . '::TopWikisQuery');
			$topWikis = array();

			if (!empty($app->wg->StatsDBEnabled)) {
				$db = wfGetDB(DB_SLAVE, array(), $app->wg->DatamartDB);

				$tables = array('report_wiki_recent_pageviews as r');
				$where = array();

				if (!empty($langs)) {
					$langs = $db->makeList($langs);
					$where[] = 'r.lang IN (' . $langs . ')';
				}

				if (!empty($hub)) {
					$hub = $db->addQuotes($hub);
					$where[] = "r.hub_name = {$hub}";
				}

				// Default to showing all wikis
				if (is_integer($public)) {
					$tables[] = 'dimension_wikis AS d';
					$where[] = 'r.wiki_id = d.wiki_id';
					$where[] = "d.public = {$public}";
				}

				$result = $db->select(
					$tables,
					array(
						'r.wiki_id AS id',
						"$field AS pageviews"
					),
					$where,
					__METHOD__,
					array(
						'ORDER BY' => 'pageviews desc',
						'LIMIT' => $limitUsed
					)
				);

				while ($row = $db->fetchObject($result)) {
					$topWikis[$row->id] = $row->pageviews;
				}
			}
			;

			wfProfileOut(__CLASS__ . '::TopWikisQuery');
			return $topWikis;
		};

		$topWikis = WikiaDataAccess::cache($memKey, 43200 /* 12 hours */, $getData);
		$topWikis = array_slice($topWikis, 0, $limit, true);

		wfProfileOut(__METHOD__);
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
	 * @param integer $public (optional) Filter results by public status, one of 0, 1 or null (for both, default)
	 *
	 * @return array $topWikis [ array( wikiId => videoviews ) ]
	 */
	public static function getTopWikisByVideoviews ($periodId, $lastN, $limit = 200) {
		$app = F::app();
		wfProfileIn(__METHOD__);

		// Define the function that our caching service will use to retrieve
		// data after a cache MISS
		$getData = function () use ($app, $periodId, $lastN) {
			if (empty($app->wg->StatsDBEnabled)) {
				return array();
			}

			wfProfileIn(__CLASS__ . '::TopWikisVideoViewQuery');

			$db = wfGetDB(DB_SLAVE, array(), $app->wg->DatamartDB);

			$tables = array('rollup_wiki_video_views as r');
			$where = array('period_id = ' . $periodId,
				"time_id > NOW() - interval $lastN day");

			// Note we *always* get the max number of results allowed and then
			// splice that list when we return.  This way we don't vary on limit
			// and cache several copies of mostly the same data.
			$result = $db->select(
				$tables,
				array(
					'r.wiki_id AS id',
					"sum(views) as totalViews"
				),
				$where,
				__METHOD__,
				array(
					'GROUP BY' => 'id',
					'ORDER BY' => 'totalViews desc',
					'LIMIT' => 200
				)
			);

			$topWikis = array();
			while ($row = $db->fetchObject($result)) {
				$topWikis[$row->id] = $row->totalViews;
			}

			wfProfileOut(__CLASS__ . '::TopWikisVideoViewQuery');
			return $topWikis;
		};

		$cacheVersion = 1;
		$memKey = wfSharedMemcKey('datamart', 'topvideowikis', $cacheVersion, $periodId);
		$topWikis = WikiaDataAccess::cache($memKey, 43200 /* 12 hours */, $getData);
		$topWikis = array_slice($topWikis, 0, $limit, true);

		wfProfileOut(__METHOD__);
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
	protected static function getEventsByWikiId ($periodId, $startDate, $endDate = null, $wikiId = null, $eventType = null) {
		$app = F::app();

		wfProfileIn(__METHOD__);

		if (empty($wikiId)) {
			$wikiId = $app->wg->CityId;
		}

		if (empty($endDate)) {
			if ($periodId == self::PERIOD_ID_MONTHLY) {
				$endDate = date('Y-m-01');
			} else {
				$endDate = date('Y-m-d', strtotime('-1 day'));
			}
		}

		$memKey = wfSharedMemcKey('datamart', 'events', $wikiId, $periodId, $startDate, $endDate);
		$events = $app->wg->Memc->get($memKey);
		if (!is_array($events)) {
			$events = array();
			if (!empty($app->wg->StatsDBEnabled)) {
				$db = wfGetDB(DB_SLAVE, array(), $app->wg->DatamartDB);

				$result = $db->select(
					array('rollup_wiki_namespace_user_events'),
					array("date_format(time_id,'%Y-%m-%d') as date, sum(creates) creates, sum(edits) edits, sum(deletes) deletes, sum(undeletes) undeletes"),
					array('period_id' => $periodId,
						'wiki_id' => $wikiId,
						"time_id between '$startDate' and '$endDate'"),
					__METHOD__,
					array('GROUP BY' => 'date, wiki_id')
				);

				while ($row = $db->fetchObject($result)) {
					$events[$row->date] = array(
						'creates' => $row->creates,
						'edits' => $row->creates + $row->edits,
						'deletes' => $row->deletes,
						'undeletes' => $row->undeletes,
					);
				}

				$app->wg->Memc->set($memKey, $events, 60 * 60 * 12);
			}
		}

		// get data depending on eventType
		if (!empty($eventType)) {
			$temp = array();
			foreach ($events as $date => $value) {
				$temp[$date] = $value[$eventType];
			}
			$events = $temp;
		}

		wfProfileOut(__METHOD__);

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
	public static function getUserEditsByWikiId ($userIds, $wikiId = null) {
		$app = F::app();
		$periodId = self::PERIOD_ID_WEEKLY;
		// Every weekly rollup is made on Sundays. We need date of penultimate Sunday.
		// We dont get penultimate date of rollup from database, becasuse of performance issue
		$rollupDate = date("Y-m-d", strtotime("Sunday 1 week ago"));

		wfProfileIn(__METHOD__);

		if ( empty($userIds) ) {
			return false;
		}

		if ( empty($wikiId) ) {
			$wikiId = $app->wg->CityId;
		}

		// this is made because memcache key has character limit and a long
		// list of user ids can be passed so we need to have it shorter
		$userIdsKey = self::makeUserIdsMemCacheKey($userIds);

		$events = WikiaDataAccess::cacheWithLock(
			wfSharedMemcKey('datamart', 'user_edits', $wikiId, $userIdsKey, $periodId, $rollupDate),
			86400 /* 24 hours */,
			function () use ($app, $wikiId, $userIds, $periodId, $rollupDate) {
				$events = [];
				if (!empty($app->wg->StatsDBEnabled)) {
					$db = wfGetDB(DB_SLAVE, array(), $app->wg->DatamartDB);

					$table = 'rollup_wiki_namespace_user_events';

					$vars = [
						'user_id',
						'sum(creates) creates',
						'sum(edits) edits',
						'sum(deletes) deletes',
						'sum(undeletes) undeletes'
					];

					$conds = [
						'period_id' => $periodId,
						'wiki_id' => $wikiId,
						'time_id' => $rollupDate,
						'user_id' => $userIds
					];

					$options = [
						'GROUP BY' => 'user_id'
					];

					$result = $db->select(
						$table,
						$vars,
						$conds,
						__METHOD__,
						$options
					);

					while ($row = $db->fetchRow($result)) {
						$events[$row['user_id']] = [
							'creates' => $row['creates'],
							'edits' => $row['creates'] + $row['edits'],
							'deletes' => $row['deletes'],
							'undeletes' => $row['undeletes'],
						];
					}
				}
				return $events;
			}
		);

		wfProfileOut(__METHOD__);

		return $events;
	}

	private static function makeUserIdsMemCacheKey($userIds) {
		$idsKey = md5(implode(',', $userIds));
		return $idsKey;
	}

	// get daily edits
	public static function getEditsDaily ($startDate, $endDate = null, $wikiId = null) {
		$edits = self::getEventsByWikiId(self::PERIOD_ID_DAILY, $startDate, $endDate, $wikiId, 'edits');

		return $edits;
	}

	// get weekly edits
	public static function getEditsWeekly ($startDate, $endDate = null, $wikiId = null) {
		$edits = self::getEventsByWikiId(self::PERIOD_ID_WEEKLY, $startDate, $endDate, $wikiId, 'edits');

		return $edits;
	}

	// get monthly edits
	public static function getEditsMonthly ($startDate, $endDate = null, $wikiId = null) {
		$edits = self::getEventsByWikiId(self::PERIOD_ID_MONTHLY, $startDate, $endDate, $wikiId, 'edits');

		return $edits;
	}

	/**
	 * Gets the list of top articles for a wiki on a weekly pageviews basis
	 *
	 * @param integer $wikiId A valid Wiki ID to fetch the list from
	 * @param Array $articleIds [OPTIONAL] A list of article ID's to restrict the list
	 * @param Array $namespaces [OPTIONAL] A list of namespace ID's to restrict the list (inclusive)
	 * @param boolean $excludeNamespaces [OPTIONAL] Sets $namespaces as an exclusive list, defaults to false
	 * @param integer $limit [OPTIONAL] The maximum number of items in the list, defaults to 200
	 *
	 * @return Array The list, the key contains article ID's and each item as a "namespace_id" and "pageviews" key
	 */
	public static function getTopArticlesByPageview( $wikiId, Array $articleIds = null, Array $namespaces = null, $excludeNamespaces = false, $limit = 200 ) {
		$app = F::app();
		wfProfileIn( __METHOD__ );

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
			( !empty( $keyToken ) ) ? md5( $keyToken ) : null,
			$excludeNamespaces
		);

		$getData = function() use ( $app, $wikiId, $namespaces, $excludeNamespaces, $articleIds, $limitUsed ) {
			wfProfileIn( __CLASS__ . '::TopArticlesQuery' );
			$topArticles = array();

			if ( !empty( $app->wg->StatsDBEnabled ) ) {
				$db = wfGetDB( DB_SLAVE, array(), $app->wg->DatamartDB );

				$where = array(
					//the rollup_wiki_article_pageviews contains only summarized data
					//with the time_id of last sunday, so fetch just that one as
					//the table is partitioned on a per-day basis and crossing
					//multiple partitions kills kittens
					'time_id = curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY',
					//for now this table supports only this period ID
					'period_id' => DataMartService::PERIOD_ID_WEEKLY,
					'wiki_id' => $wikiId
				);

				if ( !empty( $namespaces ) ) {
					$namespaces = array_filter( $namespaces, function( $val ) {
						return is_integer( $val );
					} );

					$where[] = 'namespace_id ' . ( ( !empty( $excludeNamespaces ) ) ? 'NOT ' : null ) . ' IN (' . implode( ',' , $namespaces ) . ')';
				}

				if ( !empty( $articleIds ) ) {
					$articleIds = array_filter( $articleIds, function( $val ) {
						return is_integer( $val );
					} );

					$where[] = 'article_id IN (' . implode( ',' , $articleIds ) . ')';
				}

				$result = $db->select(
					array( 'rollup_wiki_article_pageviews' ),
					array(
						'namespace_id',
						'article_id',
						'SUM(pageviews) AS pv'
					),
					$where,
					__METHOD__,
					array(
						'GROUP BY' => array( 'namespace_id', 'article_id' ),
						'ORDER BY' => 'pv DESC',
						'LIMIT'    => $limitUsed
					)
				);

				while ( $row = $db->fetchObject( $result ) ) {
					$topArticles[ $row->article_id ] = array(
						'namespace_id' => $row->namespace_id,
						'pageviews' => $row->pv
					);
				}
			};

			wfProfileOut( __CLASS__ . '::TopArticlesQuery' );
			return $topArticles;
		};

		$topArticles = WikiaDataAccess::cacheWithLock( $memKey, 86400 /* 24 hours */, $getData );
		$topArticles = array_slice( $topArticles, 0, $limit, true );
		wfProfileOut( __METHOD__ );
		return $topArticles;
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
	public static function getTopTagsWikisByPageviews ($tagId, $startDate, $endDate, $langCode = 'en', $periodId = null, $limit = 200) {
		$app = F::app();

		wfProfileIn(__METHOD__);

		if (empty($endDate)) {
			if ($periodId == self::PERIOD_ID_MONTHLY) {
				$endDate = date('Y-m-01');
			} else {
				$endDate = date('Y-m-d', strtotime('-1 day'));
			}

		}

		if (empty($periodId)) {
			$periodId = self::PERIOD_ID_MONTHLY;
		}

		$memKey = wfSharedMemcKey('datamart', 'tags_top_wikis', $tagId, $periodId, $startDate, $endDate, $langCode, $limit);
		$tagViews = $app->wg->Memc->get($memKey);
		if (!is_array($tagViews)) {
			$tagViews = array();
			if (!empty($app->wg->StatsDBEnabled)) {
				$db = wfGetDB(DB_SLAVE, array(), $app->wg->DatamartDB);

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
					'c' => array('INNER JOIN', array('c.city_id = r.wiki_id')),
					'd' => array('INNER JOIN', array('d.wiki_id = r.wiki_id', 'd.public = 1', "d.lang = '{$langCode}'"))
				);

				$result = $db->select($tables, $fields, $cond, __METHOD__, $opts, $join_conds);

				while ($row = $db->fetchObject($result)) {
					$tagViews[$row->wiki_id] = $row->pviews;
				}

				$app->wg->Memc->set($memKey, $tagViews, 60 * 60 * 12);
			}
		}

		wfProfileOut(__METHOD__);

		return $tagViews;
	}
}
