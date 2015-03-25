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
		$this->serieName = wfMessage( 'special-pageviews-report-series' )->escaped();
		$this->setDatabase( wfGetDB( DB_SLAVE, array(), F::app()->wg->DWStatsDB ) );

		$this->setStartDate( $startDate->format( 'Y-m-d' ) );
		$this->setEndDate( $endDate->format( 'Y-m-d' ) );
	}

	protected function getResults() {

		$dbr = $this->getDatabase();

		$aDataContainer = ( new WikiaSQL() )
			->SELECT( 'pageviews', 'time_id' )
			->FROM( 'rollup_wiki_pageviews' )
			->WHERE( 'period_id' )->EQUAL_TO( DataMartService::PERIOD_ID_DAILY )
			->AND_( 'time_id' )->BETWEEN( $this->startDate, $this->endDate )
			->AND_( 'wiki_id' )->EQUAL_TO( $this->App->wg->CityId )
			->runLoop( $dbr, function( &$aDataContainer, $oRow ) {
				$oDateTime = new DateTime( $oRow->time_id );
				$sDate = $oDateTime->format( 'Y-m-d' );
				$sDate = $this->frequency->formatDateByString( $sDate );
				$this->dataAll[ $sDate ][ 'date' ] = $sDate;
				$this->dataAll[ $sDate ][ 'a'.md5( $this->serieName ) ] = $oRow->pageviews;
			} );

		$this->dataTitles[ 'a'.md5( $this->serieName ) ] = $this->serieName;
	}
}
