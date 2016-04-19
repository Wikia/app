<?php

class SpecialPageViewsController extends WikiaSpecialPageController {

	const SPECIALPAGE_NAME = 'PageViews';

	private $startDate, $endDate;

	function __construct() {
		parent::__construct( self::SPECIALPAGE_NAME );
	}

	public function execute( $par ) {
		wfProfileIn( __METHOD__ );
		$this->setHeaders();

		if ( !$this->getUser()->isAllowed( 'pageviews' ) ) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}

		$this->getOutput()->addModules( 'ext.SpecialPageViews' );

		$this->setInitialDates();

		$oOutput = new SpecialPageViewsOutput;
		$oOutput->set( $this->getReport() );
		$this->setJsVars( $oOutput );
		$sReturnChart = $oOutput->getHTML();
		$this->getOutput()->addHTML( $sReturnChart );

		wfProfileOut( __METHOD__ );
	}

	public function getData() {
		$inStartDate = $this->getVal( 'startDate', date( 'Y-m-d' ) );
		$inEndDate = $this->getVal( 'endDate', date( 'Y-m-d' ) );
		$this->startDate = DateTime::createFromFormat( 'Y-m-d', $inStartDate );
		$this->endDate = DateTime::createFromFormat( 'Y-m-d', $inEndDate );

		unset( $inStartDate, $inEndDate );

		if ( !$this->startDate || !$this->endDate ) {
			$this->setInitialDates();
		}

		$oOutput = new SpecialPageViewsOutput;
		$oOutput->set( $this->getReport( $this->startDate, $this->endDate ) );

		$mOut = $oOutput->getRaw();
		$this->setVal( 'chartId', $mOut->chartId );
		$this->setVal( 'datasets', $mOut->datasets );
		$this->setVal( 'fullTicks', $mOut->fullTicks );
		$this->setVal( 'hiddenSeries', $mOut->hiddenSeries );
		$this->setVal( 'monthly', $mOut->monthly );
		$this->setVal( 'ticks', $mOut->ticks );
	}

	public function setHeaders() {
		$oOut = $this->getOutput();
		$oOut->setRobotPolicy( 'noindex,nofollow' );
		$oOut->setPageTitle( wfMessage( 'special-pageviews-title' )->escaped() );
	}

	private function getReport() {
		$oReport = new SponsorshipDashboardReport;
		$oReport->name = $this->msg( 'special-pageviews-report-title' )->escaped();
		$oReport->frequency = SponsorshipDashboardDateProvider::SD_FREQUENCY_DAY;
		$oReport->tmpSource = $this->getSource();
		$oReport->setLastDateUnits( $this->startDate->diff( $this->endDate )->days );
		$oReport->acceptSource();
		$oReport->setId( 1 );
		$oReport->lockSources();
		return $oReport;
	}

	private function setJsVars( $oOutput ) {
		$oRaw = $oOutput->getRaw();
		$aParams = [
			'chartId' => $oRaw->chartId,
			'datasets' => $oRaw->datasets,
			'fullTicks' => $oRaw->fullTicks,
			'hiddenSeries' => $oRaw->hiddenSeries,
			'monthly' => $oRaw->monthly,
			'ticks' => $oRaw->ticks,
		];
		$this->getOutput()->addJsConfigVars( 'SDParams', json_encode( $aParams ) );
	}

	private function getSource() {
		$oSource = new SpecialPageViewsSourceDatabase( 'pageviews' );
		$oSource->setupSource( $this->startDate, $this->endDate );
		return $oSource;
	}

	private function setInitialDates() {
		$this->endDate = new DateTime( date( 'Y-m-d' ) );
		$this->endDate->sub( new DateInterval( 'P1D' ) );
		$this->startDate = clone $this->endDate;
		$this->startDate->sub( new DateInterval( 'P1M' ) );
	}
}
