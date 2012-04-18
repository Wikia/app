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

			$memKey = $app->wf->MemcKey("datamart_pageviews",$periodId,$startDate,$endDate);
			$pageviews = $app->wg->Memc->get($memKey);
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
			$pageviews = $this::getPageviews( self::PERIOD_ID_WEEKLY, $startDate, $endDate, $wikiId  );

			return $pageviews;
		}

		// get monthly pageviews
		public static function getPageviewsMonthly( $startDate, $endDate=null, $wikiId=null ) {
			$pageviews = $this::getPageviews( self::PERIOD_ID_MONTHLY, $startDate, $endDate, $wikiId  );

			return $pageviews;
		}

		/**
		 * get top wikis by pageviews (last 30 days)
		 * @param type $limit
		 * @return array $topWikis [ array( wikiId => pageviews ) ]
		 */
		public static function getTopWikisByPageviews( $limit=200 ) {
			$app = F::app(); 

			$app->wf->ProfileIn( __METHOD__ );

			$limitDefault = 200;
			$limitUsed = ( $limit > $limitDefault ) ? $limit : $limitDefault ;

			$memKey = $app->wf->MemcKey( "datamart_topwikis", $limitUsed );
			$topWikis = $app->wg->Memc->get( $memKey );
			if ( !is_array($topWikis) ) {
				$topWikis = array();
				if ( !empty($app->wg->StatsDBEnabled) ) {
					$db = $app->wf->GetDB( DB_SLAVE, array(), $app->wg->DatamartDB );

					$result = $db->select(
							array( 'rollup_wiki_pageviews' ),
							array( 'wiki_id, pageviews as cnt' ),
							array(
								'period_id' => self::PERIOD_ID_DAILY,
								'time_id > curdate() - interval 30 day'
							),
							__METHOD__,
							array( 'GROUP BY' => 'wiki_id', 'ORDER BY' => 'cnt desc', 'LIMIT' => $limitUsed )
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
	}