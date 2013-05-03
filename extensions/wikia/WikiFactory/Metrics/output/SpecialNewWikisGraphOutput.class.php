<?php

class SpecialNewWikisGraphOutput extends SponsorshipDashboardOutputChart {
    
    public $active;

    public function __construct() {
        parent::__construct();
    }
    
    protected function getTemplate() {
      // TODO: REFACTOR: Use Nirvana instead of EasyTemplate.
      return new EasyTemplate( ( dirname( __FILE__ )."/templates/" ) );
    }
    
    public function getRaw() {
        $this->report->loadSources();
        $aData = $this->getChartData();
        
        $oOut = new StdClass;
        
        $oOut->chartId      = 1;
        $oOut->datasets     = isset( $aData['serie'] )     ? $aData['serie']     : array();
        $oOut->ticks        = isset( $aData['ticks'] )     ? $aData['ticks']     : array();
        $oOut->fullTicks    = isset( $aData['fullTicks'] ) ? $aData['fullTicks'] : array();
        $oOut->hiddenSeries = $this->hiddenSeries;
        $oOut->monthly      = $this->report->frequency == SponsorshipDashboardDateProvider::SD_FREQUENCY_MONTH;
        
        return $oOut;
    }
    
    public function setActive( $value ) {
        $this->active = $value;
    }
}