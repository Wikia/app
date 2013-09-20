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
			$hasfbdata = $this->getDailyLikes($stats);

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
				if ($hasfbdata && !isset($stats[$date]['likes'])) $stats[$date]['likes'] = 0;
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

		if ( !empty( $this->wg->StatsDBEnabled ) ) {
			$today = date( 'Y-m-d', strtotime('-1 day') );
			$week = date( 'Y-m-d', strtotime('-7 day') );

			$db = wfGetDB(DB_SLAVE, array(), $this->wg->StatsDB);

			$oRes = $db->select(
				array( 'events' ),
				array( "date_format(event_date, '%Y-%m-%d') date", 'count(0) as cnt' ),
				array(  "event_date between '$week 00:00:00' and '$today 23:59:59' ", 'wiki_id' => $cityID ),
				__METHOD__,
				array( 'GROUP BY' => 'date WITH ROLLUP' )
			);
			while ( $oRow = $db->fetchObject ( $oRes ) ) {
				if (!$oRow->date) { // rollup row
					$stats['totals']['edits'] = $oRow->cnt;
				} else {
					$stats[ $oRow->date ]['edits'] = $oRow->cnt;
				}
			}
		}

		wfProfileOut( __METHOD__ );
	}


	protected function getDailyPhotos(Array &$stats) {
		wfProfileIn( __METHOD__ );

		$db = wfGetDB(DB_SLAVE, array());

		$today = date( 'Ymd', strtotime('-1 day') ) . '235959';
		$week = date( 'Ymd', strtotime('-7 day') ) . '000000';

		$oRes = $db->select(
			array( 'image' ),
			array( "date_format(img_timestamp, '%Y-%m-%d') date", 'count(0) as cnt' ),
			array(  "img_timestamp between '$week' and '$today'" ),
			__METHOD__,
			array( 'GROUP BY' => 'date WITH ROLLUP')
		);
		while ( $oRow = $db->fetchObject ( $oRes ) ) {
			if (!$oRow->date) { // rollup row
				$stats['totals']['photos'] = $oRow->cnt;
			} else {
				$stats[ $oRow->date ]['photos'] = $oRow->cnt;
			}
		}

		wfProfileOut( __METHOD__ );
	}

	protected function getDailyLikes(Array &$stats) {
		global $fbAccessToken;

		$result = FALSE;
		$domain_id = Wikia::getFacebookDomainId();
		if (!$domain_id)
			return $result;

		wfProfileIn(__METHOD__);

		$since = strtotime("-7 day 00:00:00");
		$until = strtotime("-0 day 00:00:00");
		$url = 'https://graph.facebook.com/'.$domain_id.'/insights/domain_widget_likes/day?access_token='.$fbAccessToken.'&since='.$since.'&until='.$until;
		$response = json_decode(Http::get($url));

		if($response) {
			$data = array_pop($response->data);
			if(isset($data->values)) {
				$stats['totals']['likes'] = 0;
				foreach($data->values as $value) {
					if (preg_match('/([\d\-]*)/', $value->end_time, $matches)) {
						$day = $matches[1];
						$stats[$day]['likes'] = $value->value;
						$stats['totals']['likes'] += $value->value;
					}
				}
				$result = TRUE;
			}
		}
		wfProfileOut(__METHOD__);

		return $result;
	}

	public static function shortenNumberDecorator($number) {
		$number = intval($number);

		if ( $number >= 1000000000 ) {
			return wfMsg('quickstats-number-shortening-billions', array(round( $number / 1000000000, 1)));
		} elseif ($number >= 1000000 ) {
			return wfMsg('quickstats-number-shortening-millions', array(round( $number / 1000000, 1)));
		} elseif ($number >= 10000 ) {
			return wfMsg('quickstats-number-shortening', array(round( $number / 1000 , 1)));
		} else {
			return F::app()->wg->Lang->formatNum( $number );
		}
	}
}
