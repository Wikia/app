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
			$this->getDailyEdits( $stats);
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

	protected function getDailyPageViews( Array &$stats ) {
		$pageviews = RDS::getDailyTotals(7);
		$stats['totals']['pageviews'] = 0;
		foreach( $pageviews as $date => $value) {
			$stats[$date]['pageviews'] = $value;
			$stats['totals']['pageviews'] += $value;
		}
	}


	public function getDailyEdits (Array &$stats ) {
		global $wgCityId;

		$week = date( 'Y-m-d', strtotime('-7 day') );
		$res = \RDS::query(
			'SELECT dt, COUNT(*) AS total_edits '.
			'FROM wikianalytics.edits ' .
			'WHERE wiki_id = :wiki_id AND dt >= :week GROUP BY dt ' .
			'ORDER BY dt DESC LIMIT :days',
			[ ':wiki_id' => $wgCityId, ':days' => 7, ':week' => $week ]
		);

		$stats['totals']['edits'] = 0;
		foreach($res as $row) {
			// e.g. 2019-06-03 -> 128, 2
			$stats[$row->dt]['edits'] = $row->total_edits;
			$stats['totals']['edits'] += $row->total_edits;
		}
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
}
