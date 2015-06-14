<?php

class QuickStatsController extends WikiaController {

	public function getStats() {

		// First check memcache for our stats
		$memKey = wfMemcKey('quick_stats');
		$stats = $this->wg->Memc->get($memKey);
		if (!is_array($stats)) {
			$cityID = $this->wg->CityId;
			$stats = array();
			$this->getDailyPageViews( $stats );
			$this->getDailyEdits( $stats, $cityID );
			$this->getDailyPhotos( $stats );

			// totals come in from MySQL as the last element with a null date, so just pop it off and give it a keyval
			// Some of our stats can be empty, so insert zeros as defaults
			for ($i = -7 ; $i <= 0 ; $i ++) {
				$date = date( 'Y-m-d', strtotime("$i day") );
				if ($i == 0) $date = 'totals';  // last time around check the totals
				if (!isset($stats[$date])) $stats[$date] = array();
				if (!isset($stats[$date]['pageviews'])) {
					$stats[$date]['pageviews'] = 0;
				}
				if (!isset($stats[$date]['edits'])) $stats[$date]['edits'] = 0;
				if (!isset($stats[$date]['photos'])) $stats[$date]['photos'] = 0;
			}
			$this->wg->Memc->set($memKey, $stats, 60*60*12);  // Stats are daily, 12 hours lag seems reasonable
		}
		$this->totals = $stats['totals'];
		unset($stats['totals']);
		krsort($stats);
		$this->stats = $stats;
	}

	// This should probably be Unique Users but we don't have that stat
	protected function getDailyPageViews( Array &$stats ) {
		wfProfileIn( __METHOD__ );

		$week = date( 'Y-m-d', strtotime('-7 day') );

		$pageviews = DataMartService::getPageviewsDaily( $week );
		$stats['totals']['pageviews'] = 0;
		foreach( $pageviews as $date => $value) {
			$stats[$date]['pageviews'] = $value;
			$stats['totals']['pageviews'] += $value;
		}

		wfProfileOut( __METHOD__ );
	}


	public function getDailyEdits (Array &$stats, $cityID) {
		wfProfileIn( __METHOD__ );

		$today = date( 'Y-m-d', strtotime('-1 day') );
		$week = date( 'Y-m-d', strtotime('-7 day') );
		$db = wfGetDB(DB_SLAVE, array(), $this->wg->StatsDB);

		(new WikiaSQL())->skipIf(empty($this->wg->StatsDBEnabled))
			->SELECT("date_format(event_date, '%Y-%m-%d')")->AS_('date')
				->COUNT(0)->AS_('cnt')
			->FROM('events')
			->WHERE('event_date')->BETWEEN("{$week} 00:00:00", "{$today} 23:59:59")
				->AND_('wiki_id')->EQUAL_TO($cityID)
			->GROUP_BY('date WITH ROLLUP')
			->run($db, function($result) use (&$stats) {
				while ($row = $result->fetchObject()) {
					if (!$row->date) {
						$stats['totals']['edits'] = $row->cnt;
					} else {
						$stats[$row->date]['edits'] = $row->cnt;
					}
				}
			});

		wfProfileOut( __METHOD__ );
	}


	protected function getDailyPhotos(Array &$stats) {
		wfProfileIn( __METHOD__ );

		$db = wfGetDB(DB_SLAVE, array());
		$today = date( 'Ymd', strtotime('-1 day') ) . '235959';
		$week = date( 'Ymd', strtotime('-7 day') ) . '000000';

		(new WikiaSQL)
			->SELECT("date_format(img_timestamp, '%Y-%m-%d')")->AS_('date')
				->COUNT(0)->AS_('cnt')
			->FROM('image')
			->WHERE('img_timestamp')->BETWEEN($week, $today)
			->GROUP_BY('date WITH ROLLUP')
			->run($db, function($result) use (&$stats) {
				while ($row = $result->fetchObject()) {
					if (!$row->date) {
						$stats['totals']['photos'] = $row->cnt;
					} else {
						$stats[$row->date]['photos'] = $row->cnt;
					}
				}
			});

		wfProfileOut( __METHOD__ );
	}

	public static function shortenNumberDecorator($number) {
		$number = intval( $number );

		if ( $number >= 1000000000 ) {
			return wfMessage( 'quickstats-number-shortening-billions' )
				->params( round( $number / 1000000000, 1 ) )
				->parse();
		} elseif ( $number >= 1000000 ) {
			return wfMessage( 'quickstats-number-shortening-millions' )
				->params( round( $number / 1000000, 1 ) )
				->parse();
		} elseif ( $number >= 10000 ) {
			return wfMessage( 'quickstats-number-shortening' )
				->params( round( $number / 1000 , 1 ) )
				->parse();
		} else {
			return F::app()->wg->Lang->formatNum( $number );
		}
	}
}
