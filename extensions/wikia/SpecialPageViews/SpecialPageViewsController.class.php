<?php

class SpecialPageViewsController extends WikiaSpecialPageController {

	const SPECIALPAGE_NAME = 'PageViews';

	function __construct() {
		parent::__construct( self::SPECIALPAGE_NAME );
	}

	public function execute() {
		wfProfileIn( __METHOD__ );
		$this->setHeaders();

		$oOutput = ( new SpecialPageViewsOutput );

		$endDate = new DateTime( date( 'Y-m-d' ) );
		$endDate->sub( new DateInterval( 'P1D' ) );
		$startDate = clone $endDate;
		$startDate->sub( new DateInterval( 'P1M' ) );

		$oOutput->set( $this->getReport( $startDate, $endDate ) );
		$sReturnChart = $oOutput->getHTML();
		F::app()->wg->out->addHTML( $sReturnChart );

		wfProfileOut( __METHOD__ );
	}

	public function setHeaders() {
		$oOut = F::app()->wg->Out;
		$oOut->setRobotPolicy( 'noindex,nofollow' );
		$oOut->setPageTitle( wfMessage( 'special-pageviews-title' )->escaped() );
	}

	private function getReport( $startDate, $endDate ) {
		$oReport = ( new SponsorshipDashboardReport );
		$oReport->name = wfMsg( 'special-pageviews-report-title' );
		$oReport->frequency = SponsorshipDashboardDateProvider::SD_FREQUENCY_DAY;
		$oReport->tmpSource = $this->getSource( $startDate, $endDate );
		$oReport->setLastDateUnits( $startDate->diff( $endDate )->days );
		$oReport->acceptSource();
		$oReport->setId( 1 );
		$oReport->lockSources();
		return $oReport;
	}

	private function getSource( $startDate, $endDate ) {
		$oSource = new SpecialPageViewsSourceDatabase( 'pageviews' );
		$oSource->serieName = wfMsg( 'special-pageviews-report-serie' );
		$oSource->setDatabase( wfGetDB( DB_SLAVE, array(), F::app()->wg->DWStatsDB ) );

		$sql = "SELECT pageviews, DATE( time_id ) as pv_date FROM rollup_wiki_pageviews WHERE period_id='1' AND time_id >= '%s' AND time_id <= '%s' AND wiki_id = " . F::app()->wg->CityId . ";";
		$oSource->setQuery( $sql );
		$oSource->setStartDate( $startDate->format( 'Y-m-d' ) );
		$oSource->setEndDate( $endDate->format( 'Y-m-d' ) );

		return $oSource;
	}

	public function getData() {
		$inStartDate = $this->getVal( 'startDate', date( 'Y-m-d' ) );
		$inEndDate = $this->getVal( 'endDate', date( 'Y-m-d' ) );
		$startDate = DateTime::createFromFormat( 'Y-m-d', $inStartDate );
		$endDate = DateTime::createFromFormat( 'Y-m-d', $inEndDate );

		unset( $inStartDate, $inEndDate );

		if ( !$startDate || !$endDate ) {
			$endDate = new DateTime( date( 'Y-m-d' ) );
			$endDate->sub( new DateInterval( 'P1D' ) );
			$startDate = clone $endDate;
			$startDate->sub( new DateInterval( 'P1M' ) );
		}

		$oOutput = (new SpecialPageViewsOutput);
		$oOutput->set( $this->getReport( $startDate, $endDate ) );

		$mOut = $oOutput->getRaw();

		$this->setVal('chartId', $mOut->chartId );
		$this->setVal('datasets', $mOut->datasets );
		$this->setVal('fullTicks', $mOut->fullTicks );
		$this->setVal('hiddenSeries', $mOut->hiddenSeries );
		$this->setVal('monthly', $mOut->monthly );
		$this->setVal('ticks', $mOut->ticks );
	}
}
