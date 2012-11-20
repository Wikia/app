<?php

	/*
	 * DataMart Services
	 */
	class DataMartService extends Service {

		const PERIOD_ID_DAILY = 1;
		const PERIOD_ID_WEEKLY = 2;
		const PERIOD_ID_MONTHLY = 3;
		const PERIOD_ID_QUARTERLY = 4;
		const PERIOD_ID_YEARLY = 5;
		const PERIOD_ID_15MINS = 15;
		const PERIOD_ID_60MINS = 60;
		const PERIOD_ID_ROLLING_7DAYS = 1007;		// every day
		const PERIOD_ID_ROLLING_28DAYS = 1028;		// every day
		const PERIOD_ID_ROLLING_24HOURS = 10024;	// every 15 minutes

		/**
		 * get pageviews
		 * @param integer $periodId
		 * @param string $startDate [YYYY-MM-DD]
		 * @param string $endDate [YYYY-MM-DD]
		 * @param integer $wikiId
		 * @return array $pageviews [ array( 'YYYY-MM-DD' => pageviews ) ]
		 */
		protected static function getPageviews( $periodId, $startDate, $endDate = null, $wikiId = null ) {
			$app = F::app();

			$app->wf->ProfileIn( __METHOD__ );

			if ( empty($wikiId) ) {
				$wikiId = $app->wg->CityId;
			}

			if ( empty($endDate) ) {
				if ( $periodId == self::PERIOD_ID_MONTHLY ) {
					$endDate = date( 'Y-m-01' );
				} else {
					$endDate = date( 'Y-m-d', strtotime('-1 day') );
				}
			}

			$memKey = $app->wf->SharedMemcKey( 'datamart', 'pageviews', $wikiId, $periodId, $startDate, $endDate );
			$pageviews = $app->wg->Memc->get( $memKey );
			if (!is_array($pageviews) ) {
				$pageviews = array();
				if ( !empty($app->wg->StatsDBEnabled) ) {
					$db = $app->wf->GetDB( DB_SLAVE, array(), $app->wg->DatamartDB );

					$result = $db->select(
							array('rollup_wiki_pageviews'),
							array("date_format(time_id,'%Y-%m-%d') as date, pageviews as cnt"),
							array('period_id' => $periodId,
								  'wiki_id'   => $wikiId,
								  "time_id between '$startDate' and '$endDate'"),
							__METHOD__
					);

					while ( $row = $db->fetchObject($result) ) {
						$pageviews[ $row->date ] = $row->cnt;
					}

					$app->wg->Memc->set( $memKey, $pageviews, 60*60*12 );
				}
			}

			$app->wf->ProfileOut( __METHOD__ );

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
		protected static function getPageviewsForWikis( $periodId, $wikis, $startDate, $endDate = null ) {
			$app = F::app(); 

			$app->wf->ProfileIn( __METHOD__ );

			if ( empty($wikis) ) {
				$app->wf->ProfileOut( __METHOD__ );
				return array();
			}

			if ( empty($endDate) ) {
				if ( $periodId == self::PERIOD_ID_MONTHLY ) {
					$endDate = date( 'Y-m-01' );
				} else {
					$endDate = date( 'Y-m-d', strtotime('-1 day') );
				}
			}

			$wkey = md5( implode(":", $wikis) );
			$memKey = $app->wf->SharedMemcKey( 'datamart', 'pageviews_wikis', $wkey, $periodId, $startDate, $endDate );
			$pageviews = $app->wg->Memc->get( $memKey );
			if (!is_array($pageviews) ) {
				$pageviews = array();
				if ( !empty($app->wg->StatsDBEnabled) ) {
					$db = $app->wf->GetDB( DB_SLAVE, array(), $app->wg->DatamartDB );

					$result = $db->select(
						array('rollup_wiki_pageviews'),
						array("wiki_id, date_format(time_id,'%Y-%m-%d') as date, pageviews as cnt"),
						array('period_id' => $periodId,
							  'wiki_id'   => $wikis,
							  "time_id between '$startDate' and '$endDate'"
						),
						__METHOD__
					);

					while ( $row = $db->fetchObject($result) ) {
						$pageviews[ $row->wiki_id ][ $row->date ] = $row->cnt;
						$pageviews[ $row->wiki_id ][ 'SUM' ] += $row->cnt;
					}

					$app->wg->Memc->set( $memKey, $pageviews, 60*60*12 );
				}
			}

			$app->wf->ProfileOut( __METHOD__ );

			return $pageviews;
		}
		
		/**
		 * get pageviews
		 * @param array $dates ( YYYY-MM-DD, YYYY-MM-DD ... )
		 * @return array $pageviews [ array( 'YYYY-MM-DD' => pageviews ) ]
		 */
		protected static function getSumPageviewsMonthly( $dates = array() ) {
			$app = F::app();

			$app->wf->ProfileIn( __METHOD__ );
			$periodId = self::PERIOD_ID_MONTHLY;

			if ( empty($dates) ) {
				$app->wf->ProfileOut( __METHOD__ );
				return array();
			}

			$dkey = md5( implode(":", $dates) );
			$memKey = $app->wf->SharedMemcKey( 'datamart', 'sumpageviews', $periodId, $dkey );
			$pageviews = $app->wg->Memc->get( $memKey );
			if (!is_array($pageviews) ) {
				$pageviews = array();
				if ( !empty($app->wg->StatsDBEnabled) ) {
					$db = $app->wf->GetDB( DB_SLAVE, array(), $app->wg->DatamartDB );

					foreach ( $dates as $date ) {
						$row = $db->selectRow(
							array('rollup_wiki_pageviews'),
							array("sum(pageviews) as cnt"),
							array(
								'period_id' => $periodId,
								'wiki_id'   => $wikiId,
								'time_id'	=> $date
							),
							__METHOD__
						);

						if ($row) {
							$pageviews[ $date ] = intval($row->cnt);
						}
					}

					$app->wg->Memc->set( $memKey, $pageviews, 60*60*12 );
				}
			}

			$app->wf->ProfileOut( __METHOD__ );

			return $pageviews;
		}
		
		// get daily pageviews
		public static function getPageviewsDaily( $startDate, $endDate = null, $wiki = null ) {
			if ( is_array( $wiki ) ) {
				$pageviews = self::getPageviewsForWikis( self::PERIOD_ID_DAILY, /* array of Wikis */ $wiki, $startDate, $endDate );
			} else {
				$pageviews = self::getPageviews( self::PERIOD_ID_DAILY, $startDate, $endDate, /* ID */ $wiki );
			}

			return $pageviews;
		}

		// get weekly pageviews
		public static function getPageviewsWeekly( $startDate, $endDate = null, $wiki = null ) {
			if ( is_array( $wiki ) ) {
				$pageviews = self::getPageviewsForWikis( self::PERIOD_ID_WEEKLY, /* array of Wikis */ $wiki, $startDate, $endDate );
			} else {
				$pageviews = self::getPageviews( self::PERIOD_ID_WEEKLY, $startDate, $endDate, /* ID */ $wiki );
			}

			return $pageviews;
		}

		// get monthly pageviews
		public static function getPageviewsMonthly( $startDate, $endDate = null, $wiki = null ) {
			if ( is_array( $wiki ) ) {
				$pageviews = self::getPageviewsForWikis( self::PERIOD_ID_MONTHLY, /* array of Wikis */ $wiki, $startDate, $endDate );
			} else {
				$pageviews = self::getPageviews( self::PERIOD_ID_MONTHLY, $startDate, $endDate, /* ID */ $wiki );
			}

			return $pageviews;
		}
		
		/**
		 * Get top wikis by pageviews over a specified span of time, optionally filtering by
		 * public status, language and vertical (hub)
		 *
		 * @param integer $periodId The interval of time to take into consideration, one of PERIOD_ID_WEEKLY,
		 * PERIOD_ID_MONTHLY or PERIOD_ID_QUARTERLY
		 * @param integer $limit The maximum amount of results, defaults to 200
		 * @param string $lang (optional) The language code to use as a filter (e.g. en for English),
		 * null for alll (default)
		 * @param string $hub (optional) The vertical name to use as a filter (e.g. Gaming), null for all (default)
		 * @param integer $public (optional) Filter results by public status, one of 0, 1 or null (for both, default)
		 *
		 * @return array $topWikis [ array( wikiId => pageviews ) ]
		 */
		public static function getTopWikisByPageviews( $periodId, $limit = 200, $lang = null, $hub = null, $public = null ) {
			$app = F::app();
			$app->wf->ProfileIn( __METHOD__ );

			$cacheVersion = 2;
			$limitDefault = 200;
			$limitUsed = ( $limit > $limitDefault ) ? $limit : $limitDefault ;

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

			$memKey = $app->wf->SharedMemcKey( 'datamart', 'topwikis', $cacheVersion, $field, $limitUsed, $lang, $hub, $public );
			$getData = function() use ( $app, $limitUsed, $lang, $hub, $public, $field ) {
				$app->wf->ProfileIn( __CLASS__ . '::TopWikisQuery' );
				$topWikis = array();

				if ( !empty( $app->wg->StatsDBEnabled ) ) {
					$db = $app->wf->GetDB( DB_SLAVE, array(), $app->wg->DatamartDB );

					$tables = array('report_wiki_recent_pageviews as r');
					$where = array();

					if ( !empty( $lang ) ) {
						$lang = $db->addQuotes( $lang );
						$where[] = "r.lang = {$lang}";
					}

					if ( !empty( $hub ) ) {
						$hub = $db->addQuotes( $hub );
						$where[] = "r.hub_name = {$hub}";
					}

					// Default to showing all wikis
					if ( is_integer( $public ) ) {
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
							'LIMIT'    => $limitUsed
						)
					);

					while ( $row = $db->fetchObject( $result ) ) {
						$topWikis[ $row->id ] = $row->pageviews;
					}
				};

				$app->wf->ProfileOut( __CLASS__ . '::TopWikisQuery' );
				return $topWikis;
			};

			$topWikis = WikiaDataAccess::cache( $memKey, 43200 /* 12 hours */, $getData );
			$topWikis = array_slice( $topWikis, 0, $limit, true );

			$app->wf->ProfileOut( __METHOD__ );
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
		protected static function getEventsByWikiId( $periodId, $startDate, $endDate = null, $wikiId = null, $eventType = null ) {
			$app = F::app();

			$app->wf->ProfileIn( __METHOD__ );

			if ( empty($wikiId) ) {
				$wikiId = $app->wg->CityId;
			}

			if ( empty($endDate) ) {
				if ( $periodId == self::PERIOD_ID_MONTHLY ) {
					$endDate = date( 'Y-m-01' );
				} else {
					$endDate = date( 'Y-m-d', strtotime('-1 day') );
				}
			}

			$memKey = $app->wf->SharedMemcKey( 'datamart', 'events', $wikiId, $periodId, $startDate, $endDate );
			$events = $app->wg->Memc->get( $memKey );
			if (!is_array($events) ) {
				$events = array();
				if ( !empty($app->wg->StatsDBEnabled) ) {
					$db = $app->wf->GetDB( DB_SLAVE, array(), $app->wg->DatamartDB );

					$result = $db->select(
							array('rollup_wiki_namespace_user_events'),
							array("date_format(time_id,'%Y-%m-%d') as date, sum(creates) creates, sum(edits) edits, sum(deletes) deletes, sum(undeletes) undeletes"),
							array('period_id' => $periodId,
								  'wiki_id'   => $wikiId,
								  "time_id between '$startDate' and '$endDate'"),
							__METHOD__,
							array('GROUP BY' => 'date, wiki_id')
					);

					while ( $row = $db->fetchObject($result) ) {
						$events[$row->date] = array(
							'creates' => $row->creates,
							'edits' => $row->creates + $row->edits,
							'deletes' => $row->deletes,
							'undeletes' => $row->undeletes,
						);
					}

					$app->wg->Memc->set( $memKey, $events, 60*60*12 );
				}
			}

			// get data depending on eventType
			if ( !empty($eventType) ) {
				$temp = array();
				foreach( $events as $date => $value ) {
					$temp[$date] = $value[$eventType];
				}
				$events = $temp;
			}

			$app->wf->ProfileOut( __METHOD__ );

			return $events;
		}

		// get daily edits
		public static function getEditsDaily( $startDate, $endDate = null, $wikiId = null ) {
			$edits = self::getEventsByWikiId( self::PERIOD_ID_DAILY, $startDate, $endDate, $wikiId, 'edits' );

			return $edits;
		}

		// get weekly edits
		public static function getEditsWeekly( $startDate, $endDate = null, $wikiId = null ) {
			$edits = self::getEventsByWikiId( self::PERIOD_ID_WEEKLY, $startDate, $endDate, $wikiId, 'edits' );

			return $edits;
		}

		// get monthly edits
		public static function getEditsMonthly( $startDate, $endDate = null, $wikiId = null ) {
			$edits = self::getEventsByWikiId( self::PERIOD_ID_MONTHLY, $startDate, $endDate, $wikiId, 'edits' );

			return $edits;
		}

		/**
		 * get video views by video title
		 * @param string $title
		 * @param integer $periodId
		 * @param string $startDate [YYYY-MM-DD]
		 * @param string $endDate [YYYY-MM-DD]
		 * @param integer $wikiId
		 * @return array $videoviews [ array( 'YYYY-MM-DD' => videoviews ) ]
		 */
		protected static function getVideoViewsByTitle( $title, $periodId, $startDate, $endDate = null, $wikiId = null ) {
			$app = F::app();

			$app->wf->ProfileIn( __METHOD__ );

			if ( empty($wikiId) ) {
				$wikiId = $app->wg->CityId;
			}

			if ( empty($endDate) ) {
				if ( $periodId == self::PERIOD_ID_MONTHLY ) {
					$endDate = date( 'Y-m-01' );
				} else {
					$endDate = date( 'Y-m-d', strtotime('-1 day') );
				}
			}

			$memKey = $app->wf->SharedMemcKey( 'datamart', 'video_views', $wikiId, $periodId, $startDate, $endDate, md5($title) );
			$videoViews = $app->wg->Memc->get( $memKey );
			if (!is_array($videoViews) ) {
				$videoViews = array();
				if ( !empty($app->wg->StatsDBEnabled) ) {
					$db = $app->wf->GetDB( DB_SLAVE, array(), $app->wg->DatamartDB );

					$result = $db->select(
							array( 'rollup_wiki_video_views' ),
							array( "date_format(time_id,'%Y-%m-%d') as date, views as cnt" ),
							array(
								'period_id'   => $periodId,
								'wiki_id'     => $wikiId,
								'video_title' => $title,
								"time_id between '$startDate' and '$endDate'"
							),
							__METHOD__
					);

					while ( $row = $db->fetchObject($result) ) {
						$videoViews[ $row->date ] = $row->cnt;
					}

					$app->wg->Memc->set( $memKey, $videoViews, 60*60*12 );
				}
			}

			$app->wf->ProfileOut( __METHOD__ );

			return $videoViews;
		}

		// get daily video views by video title
		public static function getVideoViewsByTitleDaily( $title, $startDate, $endDate = null, $wikiId = null ) {
			$videoViews = self::getVideoViewsByTitle( $title, self::PERIOD_ID_DAILY, $startDate, $endDate, $wikiId );

			return $videoViews;
		}

		// get monthly video views by video title
		public static function getVideoViewsByTitleMonthly( $title, $startDate, $endDate = null, $wikiId = null ) {
			$videoViews = self::getVideoViewsByTitle( $title, self::PERIOD_ID_MONTHLY, $startDate, $endDate, $wikiId );

			return $videoViews;
		}

		/**
		 * get total video views by video title
		 * @param string $title
		 * @param integer $periodId
		 * @param string $startDate [YYYY-MM-DD]
		 * @param string $endDate [YYYY-MM-DD]
		 * @param integer $wikiId
		 * @return integer $videoviews
		 */
		public static function getVideoViewsByTitleTotal( $title, $periodId = null, $startDate = null, $endDate = null, $wikiId = null ) {
			$videoList = self::getVideoListViewsByTitleTotal( $periodId, $startDate, $endDate, $wikiId );
			$hashTitle = md5( $title );
			$videoViews = ( isset($videoList[$hashTitle]) ) ? $videoList[$hashTitle] : 0;

			return $videoViews;
		}

		/**
		 * get list of total video views by video title
		 * @param integer $periodId
		 * @param string $startDate [YYYY-MM-DD]
		 * @param string $endDate [YYYY-MM-DD]
		 * @param integer $wikiId
		 * @return array $videoviews [ array( md5(video_title) => videoviews ) ]
		 */
		public static function getVideoListViewsByTitleTotal( $periodId = null, $startDate = null, $endDate = null, $wikiId = null ) {
			$app = F::app();

			$app->wf->ProfileIn( __METHOD__ );

			if ( empty($wikiId) ) {
				$wikiId = $app->wg->CityId;
			}

			if ( empty($endDate) ) {
				if ( $periodId == self::PERIOD_ID_MONTHLY ) {
					$endDate = date( 'Y-m-01' );
				} else {
					$endDate = date( 'Y-m-d', strtotime('-1 day') );
				}
			}

			if ( empty($startDate) ) {
				$startDate = '2012-07-01'; // start tracking video view
			}

			if ( empty($periodId) ) {
				$periodId = self::PERIOD_ID_MONTHLY;
			}

			$memKey = $app->wf->SharedMemcKey( 'datamart', 'total_video_views', 'v2', $wikiId, $periodId, $startDate, $endDate );
			$videoViews = $app->wg->Memc->get( $memKey );
			if ( !is_array($videoViews) ) {
				$videoViews = array();
				if ( !empty($app->wg->StatsDBEnabled) ) {
					$db = $app->wf->GetDB( DB_SLAVE, array(), $app->wg->DatamartDB );

					$result = $db->select(
							array( 'rollup_wiki_video_views' ),
							array( 'video_title, ifnull(sum(views),0) as cnt' ),
							array(
								'period_id'   => $periodId,
								'wiki_id'     => $wikiId,
								"time_id between '$startDate' and '$endDate'"
							),
							__METHOD__,
							array(
								'GROUP BY' => 'video_title',
								'LIMIT' => '10000',
							)
					);

					while ( $row = $db->fetchObject($result) ) {
						$hashTitle = md5( $row->video_title );
						$videoViews[$hashTitle] = $row->cnt;
					}

					$app->wg->Memc->set( $memKey, $videoViews, 60*60*12 );
				}
			}

			$app->wf->ProfileOut( __METHOD__ );

			return $videoViews;
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
			$app->wf->ProfileIn( __METHOD__ );

			$cacheVersion = 1;
			$limitDefault = 200;
			$limitUsed = ( $limit > $limitDefault ) ? $limit : $limitDefault ;

			//in Dev environment data is not updated, use an available range
			if ( !empty( $app->wg->DevelEnvironment ) ) {
				$startDate = '2012-10-07';
				$endDate = '2012-10-14';
			} else {
				$startDate = date( 'Y-m-d', strtotime( 'last week last monday' ) );
				$endDate = date( 'Y-m-d', strtotime('last week next sunday') );
			}

			$keyToken = '';

			if ( is_array( $namespaces ) ) {
				$keyToken .= implode( ':', $namespaces );
			}

			if ( is_array( $articleIds ) ) {
				$keyToken .= implode( ':', $articleIds );
			}

			$memKey = $app->wf->SharedMemcKey(
				'datamart',
				'toparticles',
				$cacheVersion,
				$wikiId,
				$limitUsed,
				( !empty( $keyToken ) ) ? md5( $keyToken ) : null,
				$excludeNamespaces
			);
			$getData = function() use ( $app, $wikiId, $namespaces, $excludeNamespaces, $articleIds, $startDate, $endDate, $limitUsed ) {
				$app->wf->ProfileIn( __CLASS__ . '::TopArticlesQuery' );
				$topArticles = array();

				if ( !empty( $app->wg->StatsDBEnabled ) ) {
					$db = $app->wf->GetDB( DB_SLAVE, array(), $app->wg->DatamartDB );

					$where = array(
						'time_id' => array( $startDate, $endDate ),
						'period_id' => DataMartService::PERIOD_ID_WEEKLY,//for now this table supports only this period ID
						'wiki_id' => $wikiId
					);

					if ( is_array( $namespaces ) ) {
						$namespaces = array_filter( $namespaces, function( $val ) {
							return is_integer( $val );
						} );

						$where[] = 'namespace_id ' . ( ( !empty( $excludeNamespaces ) ) ? 'NOT ' : null ) . ' IN (' . implode( ',' , $namespaces ) . ')';
					}

					if ( is_array( $articleIds ) ) {
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

				$app->wf->ProfileOut( __CLASS__ . '::TopArticlesQuery' );
				return $topArticles;
			};

			$topArticles = WikiaDataAccess::cacheWithLock( $memKey, 86400 /* 24 hours */, $getData );
			$topArticles = array_slice( $topArticles, 0, $limit, true );

			$app->wf->ProfileOut( __METHOD__ );
			return $topArticles;
		}
		
		/**
		 * Returns the latest WAM score provided a wiki ID
		 * @param int $wikiId
		 * @return number
		 */
		public static function getCurrentWamScoreForWiki( $wikiId ) {
			$app = F::app();
			$app->wf->ProfileIn( __METHOD__ );
			
			$memKey = $app->wf->SharedMemcKey( 'datamart', 'wam', $wikiId );
			
			$getData = function() use ( $app, $wikiId ) {
				$db = $app->wf->GetDB( DB_SLAVE, array(), $app->wg->DatamartDB );
				
				$result = $db->select(
							array( 'fact_wam_scores' ),
							array(
								'wam'
							),
							array(
								'wiki_id' => $wikiId
							),
							__METHOD__,
							array(
								'ORDER BY' => 'time_id DESC',
								'LIMIT' => 1
							)
						);
				
				return ( $row = $db->fetchObject( $result ) ) ? $row->wam : 0;
			};
			
			$wamScore = WikiaDataAccess::cacheWithLock( $memKey, 86400 /* 24 hours */, $getData );
			$app->wf->ProfileOut( __METHOD__ );
			return $wamScore;
		}
		
		/**
		 * Gets the list of top wikis for tag_id and language on a monthly pageviews basis
		 * 
		 * @param integer $tagId A valid tag_id from city_tag_map table
		 * @param string $startDate [YYYY-MM-DD]
		 * @param string $endDate [YYYY-MM-DD]
		 * @param integer $langCode A valid Wiki's language code 
		 * @param integer $periodId
		 * @param integer $limit [OPTIONAL] The maximum number of items in the list, defaults to 200
		 *
		 * @return Array The list, the key contains Wiki ID's and "pageviews" number
		 */
		public static function getTopTagsWikisByPageviews( $tagId, $startDate, $endDate, $langCode = 'en', $periodId = null, $limit = 200 ) {
			$app = F::app();

			$app->wf->ProfileIn( __METHOD__ );

			if ( empty($endDate) ) {
				if ( $periodId == self::PERIOD_ID_MONTHLY ) {
					$endDate = date( 'Y-m-01' );
				} else {
					$endDate = date( 'Y-m-d', strtotime('-1 day') );
				}
			}

			if ( empty($periodId) ) {
				$periodId = self::PERIOD_ID_MONTHLY;
			}

			$memKey = $app->wf->SharedMemcKey( 'datamart', 'tags_top_wikis', $tagId, $periodId, $startDate, $endDate, $langCode = 'en', $limit );
			$tagViews = $app->wg->Memc->get( $memKey );
			if ( !is_array($tagViews) ) {
				$tagViews = array();
				if ( !empty($app->wg->StatsDBEnabled) ) {
					$db = $app->wf->GetDB( DB_SLAVE, array(), $app->wg->DatamartDB );

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
						'tag_id'	=> $tagId,
						"time_id between '{$startDate}' AND '{$endDate}'", 
					);
					$opts = array( 
						'GROUP BY'	=> 'c.tag_id, r.wiki_id',
						'ORDER BY'	=> 'pviews DESC',
						'LIMIT'		=> $limit
					);
					$join_conds = array( 
						'c' => array( 'INNER JOIN', array( 'c.city_id = r.wiki_id' ) ),
						'd' => array( 'INNER JOIN', array( 'd.wiki_id = r.wiki_id', 'd.public = 1', "d.lang = '{$langCode}'" ) )
					);

					$result = $db->select( $tables, $fields, $cond, __METHOD__, $opts, $join_conds );

					while ( $row = $db->fetchObject($result) ) {
						$tagViews[ $row->wiki_id ] = $row->pviews;
					}

					$app->wg->Memc->set( $memKey, $tagViews, 60*60*12 );
				}
			}

			$app->wf->ProfileOut( __METHOD__ );

			return $tagViews;
		}
	}
