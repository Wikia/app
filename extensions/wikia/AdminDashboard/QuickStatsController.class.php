<?php

class QuickStatsController extends WikiaController {
	
	public function getStats() {

		// fixme: refactor this into a service?
		$cityID = $this->wg->CityId;
		$stats = array();
		$this->getDailyPageViews( $stats, $cityID );
		$this->getDailyEdits( $stats, $cityID );
		$this->getDailyPhotos( $stats );
		// totals come in as the last element with a null date, so just pop it off and give it a keyval 
		$stats['totals'] = array_pop($stats);
		// Some of our stats can be empty, so insert zeros there
		for ($i = -7 ; $i <= 0 ; $i ++) {
			$date = date( 'Y-m-d', strtotime("$i day") );
			if ($i == 0) $date = 'totals';  // last time around check the totals
			if (!isset($stats[$date])) $stats[$date] = array();
			if (!isset($stats[$date]['pageviews'])) $stats[$date]['pageviews'] = 0;
			if (!isset($stats[$date]['edits'])) $stats[$date]['edits'] = 0;
			if (!isset($stats[$date]['photos'])) $stats[$date]['photos'] = 0;
			if (!isset($stats[$date]['likes'])) $stats[$date]['likes'] = 0;
		}
		$this->stats = array_reverse($stats);
	}
	
	// This should probably be Unique Users but we don't have that stat
	protected function getDailyPageViews( Array &$stats, $cityID) {
		$this->wf->ProfileIn( __METHOD__ );

		$dailyPageViews = array(); 
		if ( !empty( $this->wg->StatsDBEnabled ) ) {
			$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->StatsDB);

			$today = date( 'Ymd', strtotime('-1 day') );
			$week = date( 'Ymd', strtotime('-7 day') );

			$oRes = $db->select(
				array( 'page_views' ),
				array( "date_format(pv_use_date, '%Y-%m-%d') date", 'sum(pv_views) as cnt'  ),
				array(  "pv_use_date between '$week' and '$today' ", 'pv_city_id' => $cityID ),
				__METHOD__,
				array('GROUP BY'	=> 'date WITH ROLLUP')
			);
			
			while ( $oRow = $db->fetchObject ( $oRes ) ) { 
				$stats[ $oRow->date ]['pageviews'] = $oRow->cnt;
			} 
		}
			
		wfProfileOut( __METHOD__ );
		return $dailyPageViews;				
	}	

		
	public function getDailyEdits (Array &$stats, $cityID) {
		$this->wf->ProfileIn( __METHOD__ );
		
		if ( !empty( $this->wg->StatsDBEnabled ) ) {
			$today = date( 'Y-m-d', strtotime('-1 day') );
			$week = date( 'Y-m-d', strtotime('-7 day') );
			
			$db = $this->wf->GetDB(DB_SLAVE, array(), $this->wg->StatsDB);

			$oRes = $db->select( 
				array( 'events' ), 
				array( "date_format(event_date, '%Y-%m-%d') date", 'count(0) as cnt' ),
				array(  "event_date between '$week 00:00:00' and '$today 23:59:59' ", 'wiki_id' => $cityID ),
				__METHOD__, 
				array( 'GROUP BY' => 'date WITH ROLLUP' )
			);
			while ( $oRow = $db->fetchObject ( $oRes ) ) { 
				$stats[ $oRow->date ]['edits'] = $oRow->cnt;
			} 
		}
		
		$this->wf->ProfileOut( __METHOD__ );		
	}
	
	
	protected function getDailyPhotos(Array &$stats) {
		$this->wf->ProfileIn( __METHOD__ );
		
		$db = $this->wf->GetDB(DB_SLAVE, array());
		
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
			$stats[ $oRow->date ]['photos'] = $oRow->cnt;
		} 
		
		$this->wf->ProfileOut( __METHOD__ );		
	}
	
	protected function getDailyLikes($cityID, $date) {
		
	}
	
}
