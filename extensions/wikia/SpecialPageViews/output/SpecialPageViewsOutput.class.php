<?php

class SpecialPageViewsOutput extends SponsorshipDashboardOutputChart {

	public $active;

	public function __construct() {
		parent::__construct();
	}

	protected function getTemplate() {
		return new EasyTemplate( ( dirname( __FILE__ )."/templates/" ) );
	}

	public function getRaw() {
		$this->report->loadSources();
		$aData = $this->getChartData();

		$oOut = new StdClass;

		$oOut->chartId      = 1;
		$oOut->datasets     = isset( $aData['serie'] )     ? $aData['serie']     : [];
		$oOut->ticks        = isset( $aData['ticks'] )     ? $aData['ticks']     : [];
		$oOut->fullTicks    = isset( $aData['fullTicks'] ) ? $aData['fullTicks'] : [];
		$oOut->hiddenSeries = $this->hiddenSeries;
		$oOut->monthly      = $this->report->frequency == SponsorshipDashboardDateProvider::SD_FREQUENCY_MONTH;

		return $oOut;
	}

	public function setActive( $value ) {
		$this->active = $value;
	}
}
