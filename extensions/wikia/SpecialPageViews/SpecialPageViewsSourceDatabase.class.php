<?php

class SpecialPageViewsSourceDatabase extends SponsorshipDashboardSourceDatabase {

	public function setStartDate( $date ) {
		$this->startDate = $date;
	}

	public function setEndDate( $date ) {
		$this->endDate = $date;
	}

	public function getData() {
		$this->loadData();
	}

	public function setupSource( $startDate, $endDate ) {
		$this->serieName = wfMessage( 'special-pageviews-report-serie' )->escaped();
		$this->setDatabase( wfGetDB( DB_SLAVE, array(), F::app()->wg->DWStatsDB ) );

		$sql = "SELECT pageviews, DATE( time_id ) as pv_date FROM rollup_wiki_pageviews WHERE period_id='1' AND time_id >= '%s' AND time_id <= '%s' AND wiki_id = " . F::app()->wg->CityId . ";";
		$this->setQuery( $sql );
		$this->setStartDate( $startDate->format( 'Y-m-d' ) );
		$this->setEndDate( $endDate->format( 'Y-m-d' ) );
	}

	protected function getResults() {

		$sql = sprintf( $this->sQuery, $this->startDate, $this->endDate );

		$dbr = $this->getDatabase();
		$res = $dbr->query( $sql, __METHOD__ );

		while ( $row = $res->fetchObject( $res ) ) {
			$sDate = $row->pv_date;
			$sDate = $this->frequency->formatDateByString( $sDate );
			$this->dataAll[ $sDate ][ 'date' ] = $sDate;
			$this->dataAll[ $sDate ][ 'a'.md5( $this->serieName ) ] = $row->pageviews;
		}

		$this->dataTitles[ 'a'.md5( $this->serieName ) ] = $this->serieName;
	}
}
