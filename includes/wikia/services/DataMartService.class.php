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
		protected static function getPageviews( $periodId, $startDate, $endDate=null, $wikiId=null ) {
			$app = F::app(); 

			$app->wf->ProfileIn( __METHOD__ );

			if ( empty($wikiId) ) {
				$wikiId = $app->wg->CityId;
			}

			if ( empty($endDate) ) {
				$endDate = date( 'Y-m-d', strtotime('-1 day') );
			}

			$memKey = $app->wf->SharedMemcKey( 'datamart', 'pageviews', $wikiId, $periodId, $startDate, $endDate );
			$pageviews = $app->wg->Memc->get( $memKey );
			if ( !is_array($pageviews) ) {
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
		public static function getPageviewsDaily( $startDate, $endDate=null, $wikiId=null ) {
			$pageviews = self::getPageviews( self::PERIOD_ID_DAILY, $startDate, $endDate, $wikiId  );

			return $pageviews;
		}

		// get weekly pageviews
		public static function getPageviewsWeekly( $startDate, $endDate=null, $wikiId=null ) {
			$pageviews = self::getPageviews( self::PERIOD_ID_WEEKLY, $startDate, $endDate, $wikiId  );

			return $pageviews;
		}

		// get monthly pageviews
		public static function getPageviewsMonthly( $startDate, $endDate=null, $wikiId=null ) {
			$pageviews = self::getPageviews( self::PERIOD_ID_MONTHLY, $startDate, $endDate, $wikiId  );

			return $pageviews;
		}

		/**
		 * get top wikis by pageviews (last 30 days) and optionally by language
		 * @param integer $limit
		 * @param string $lang (optional)
		 * @param integer $public (optional)
		 * @return array $topWikis [ array( wikiId => pageviews ) ]
		 */
		public static function getTopWikisByPageviews( $limit=200, $lang=null, $public=null ) {
			$app = F::app(); 

			$app->wf->ProfileIn( __METHOD__ );

			$limitDefault = 200;
			$limitUsed = ( $limit > $limitDefault ) ? $limit : $limitDefault ;

			$memKey = $app->wf->SharedMemcKey( 'datamart', 'topwikis', $limitUsed, $lang );
			$topWikis = $app->wg->Memc->get( $memKey );
			if (!is_array($topWikis) ) {
				$topWikis = array();
				if ( !empty($app->wg->StatsDBEnabled) ) {
					$db = $app->wf->GetDB( DB_SLAVE, array(), $app->wg->DatamartDB );

					$tables[] = 'rollup_wiki_pageviews';
					$where  = array('period_id' => self::PERIOD_ID_DAILY,
									'time_id > CURDATE() - INTERVAL 30 DAY'
							  );

					if (!is_null($lang) || $public) {
						$tables[] = 'dimension_wikis';
						$where[]  = 'rollup_wiki_pageviews.wiki_id = dimension_wikis.wiki_id';
					}
					if ($lang) {
						$where[] = "lang = '$lang'";
					}

					// Default to showing public wikis
					if (!is_null($public)) {
						$where[] = 'public = '.$public;
					} else {
						$where[] = 'public = 1';
					}

					$result = $db->select(
							$tables,
							array( 'rollup_wiki_pageviews.wiki_id, sum(pageviews) as cnt' ),
							$where,
							__METHOD__,
							array( 'GROUP BY' => 'rollup_wiki_pageviews.wiki_id',
								   'ORDER BY' => 'cnt desc',
								   'LIMIT'    => $limitUsed )
					);

					while ( $row = $db->fetchObject($result) ) {
						$topWikis[ $row->wiki_id ] = $row->cnt;
					}

					$app->wg->Memc->set( $memKey, $topWikis, 60*60*12 );
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
		protected static function getEventsByWikiId( $periodId, $startDate, $endDate=null, $wikiId=null, $eventType=null ) {
			$app = F::app(); 

			$app->wf->ProfileIn( __METHOD__ );

			if ( empty($wikiId) ) {
				$wikiId = $app->wg->CityId;
			}

			if ( empty($endDate) ) {
				$endDate = date( 'Y-m-d', strtotime('-1 day') );
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
		public static function getEditsDaily( $startDate, $endDate=null, $wikiId=null ) {
			$edits = self::getEventsByWikiId( self::PERIOD_ID_DAILY, $startDate, $endDate, $wikiId, 'edits'  );

			return $edits;
		}

		// get weekly edits
		public static function getEditsWeekly( $startDate, $endDate=null, $wikiId=null ) {
			$edits = self::getEventsByWikiId( self::PERIOD_ID_WEEKLY, $startDate, $endDate, $wikiId, 'edits'  );

			return $edits;
		}

		// get monthly edits
		public static function getEditsMonthly( $startDate, $endDate=null, $wikiId=null ) {
			$edits = self::getEventsByWikiId( self::PERIOD_ID_MONTHLY, $startDate, $endDate, $wikiId, 'edits'  );

			return $edits;
		}

	}