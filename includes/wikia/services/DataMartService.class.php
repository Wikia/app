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


		protected static function getPageviews( $periodId, $startDate, $endDate=null, $wikiId=null ) {
			$app = F::app(); 

			$app->wf->ProfileIn( __METHOD__ );

			if ( empty($wikiId) ) {
				$wikiId = $app->wg->CityId;
			}

			if ( empty($endDate) ) {
				$endDate = date( 'Y-m-d', strtotime('-1 day') );
			}

			$memKey = $app->wf->MemcKey("pageviews",$periodId,$startDate,$endDate);
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

		public static function getPageviewsDaily( $startDate, $endDate=null, $wikiId=null ) {
			$pageviews = self::getPageviews( self::PERIOD_ID_DAILY, $startDate, $endDate, $wikiId  );

			return $pageviews;
		}

		public static function getPageviewsWeekly( $startDate, $endDate=null, $wikiId=null ) {
			$pageviews = $this::getPageviews( self::PERIOD_ID_WEEKLY, $startDate, $endDate, $wikiId  );

			return $pageviews;
		}

		public static function getPageviewsMonthly( $startDate, $endDate=null, $wikiId=null ) {
			$pageviews = $this::getPageviews( self::PERIOD_ID_MONTHLY, $startDate, $endDate, $wikiId  );

			return $pageviews;
		}
	}