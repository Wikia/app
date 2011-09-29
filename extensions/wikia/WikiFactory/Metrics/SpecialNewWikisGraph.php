<?php

class SpecialNewWikisGraph extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'NewWikisGraph', 'wikifactorymetrics' /* restriction */ );
	}


	public function execute() {
		global $wgExternalSharedDB, $wgOut;

		$this->setHeaders();
	
		$oSource = new SponsorshipDashboardSourceDatabase( 'wikicreations' );
		$oSource->serieName = "wikis created";

		$oSource->setDatabase( wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB ) );

		$sql = "SELECT count(city_id) as number, DATE( city_created ) as creation_date
			FROM city_list
			WHERE city_created >= '%s'
			AND city_created <= '%s'";
		$sql .= " GROUP BY creation_date ORDER BY city_created";

		$oSource->setQuery( $sql );

		$oReport = new SponsorshipDashboardReport();
		$oReport->name = 'wiki creations by day';

		$oReport->setLastDateUnits( 30 );
		$oReport->frequency = SponsorshipDashboardDateProvider::SD_FREQUENCY_DAY;

		$oReport->tmpSource = $oSource;
		$oReport->acceptSource();

                $oReport->setId( 0 );
                $oReport->lockSources();

		$oOutput = new SponsorshipDashboardOutputChart ( );
		$oOutput->set( $oReport );
		$returnChart = $oOutput->getHTML();

		$wgOut->addHTML( $returnChart );
	}
}
