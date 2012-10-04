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

		// get daily pageviews
		public static function getPageviewsDaily( $startDate, $endDate = null, $wikiId = null ) {
			$pageviews = self::getPageviews( self::PERIOD_ID_DAILY, $startDate, $endDate, $wikiId );

			return $pageviews;
		}

		// get weekly pageviews
		public static function getPageviewsWeekly( $startDate, $endDate = null, $wikiId = null ) {
			$pageviews = self::getPageviews( self::PERIOD_ID_WEEKLY, $startDate, $endDate, $wikiId );

			return $pageviews;
		}

		// get monthly pageviews
		public static function getPageviewsMonthly( $startDate, $endDate = null, $wikiId = null ) {
			$pageviews = self::getPageviews( self::PERIOD_ID_MONTHLY, $startDate, $endDate, $wikiId );

			return $pageviews;
		}

		/**
		 * Get top wikis by pageviews over a specified span of time, optionally filtering by
		 * public status and language
		 *
		 * @param integer $limit The maximum amount of results
		 * @param string $lang (optional) The language code to use as a filter (e.g. en for English)
		 * @param string $hub (optional) The vertical name to use as a filter (e.g. Gaming)
		 * @param integer $public (optional) Filter results by public status
		 * @param integer $interval The interval of time to take into consideration, in days
		 *
		 * @return array $topWikis [ array( wikiId => pageviews ) ]
		 */
		public static function getTopWikisByPageviews( $limit = 200, $lang = null, $hub = null, $public = null, $interval = 30 ) {
			$app = F::app();

			$app->wf->ProfileIn( __METHOD__ );

			$limitDefault = 200;
			$limitUsed = ( $limit > $limitDefault ) ? $limit : $limitDefault ;

			$memKey = $app->wf->SharedMemcKey( 'datamart', 'topwikis', $limitUsed, $lang, $hub, $public, $interval );
			$topWikis = $app->wg->Memc->get( $memKey );

			if ( !is_array( $topWikis ) ) {
				$topWikis = array();

				if ( !empty( $app->wg->StatsDBEnabled ) ) {
					$db = $app->wf->GetDB( DB_SLAVE, array(), $app->wg->DatamartDB );
					$ignoreIndex = ($lang == null && $hub == null) ? ' IGNORE INDEX (wiki_time_period)' : '';
					$tables = array(
						'rollup_wiki_pageviews AS r' . $ignoreIndex,
						'dimension_wikis AS d'
					);
					$where  = array(
						'r.period_id' => self::PERIOD_ID_DAILY,
						"r.time_id > CURDATE() - INTERVAL {$interval} DAY",
						'r.wiki_id = d.wiki_id'
					);

					if ( !is_null( $lang ) ) {
						$where[] = "d.lang = '{$lang}'";
					}

					if ( !is_null( $hub ) ) {
						$where[] = "d.hub_name = '{$hub}'";
					}

					// Default to showing public wikis
					if ( !is_null( $public ) ) {
						$where[] = "d.public = {$public}";
					} else {
						$where[] = 'd.public = 1';
					}

					$result = $db->select(
							$tables,
							array(
								'r.wiki_id AS id',
								'sum(r.pageviews) AS pageviews'
							),
							$where,
							__METHOD__,
							array(
								'GROUP BY' => 'r.wiki_id',
								'ORDER BY' => 'pageviews desc',
								'LIMIT'    => $limitUsed
							)
					);

					while ( $row = $db->fetchObject( $result ) ) {
						$topWikis[ $row->id ] = $row->pageviews;
					}

					$app->wg->Memc->set( $memKey, $topWikis, 43200 /* 12 hours */ );
				}
			}

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

	}
