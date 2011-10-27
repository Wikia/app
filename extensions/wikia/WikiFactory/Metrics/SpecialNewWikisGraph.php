<?php

class SpecialNewWikisGraph extends UnlistedSpecialPage {

	private $aAvailableLanguages = array( 'en', 'de', 'es', 'fr', 'it', 'ja', 'nl', 'no', 'pl', 'pt', 'pt-br', 'ru', 'zh' );
	private $aAvailableOtherOptions = array( 'other', 'all' );

	public function __construct() {
		parent::__construct( 'NewWikisGraph', 'wikifactorymetrics' /* restriction */ );
	}


	public function execute( $param ) {
		
		$aAllOptions = array_merge( $this->aAvailableLanguages, $this->aAvailableOtherOptions );
		$param = ( in_array( $param, $aAllOptions ) ? $param : '' );

		$this->setHeaders();
		
		$oSource = F::build( 'SponsorshipDashboardSourceDatabase' , array( 'wikicreations'.$param ) );
		$oSource->serieName = wfMsg( 'newwikisgraph-wikis-created' );

		$oSource->setDatabase( wfGetDB( DB_SLAVE, array(), F::app()->wg->externalSharedDB ) );

		$sql = "SELECT count(city_id) as number, DATE( city_created ) as creation_date
			FROM city_list
			WHERE city_created >= '%s'
			AND city_created <= '%s'";

		if ( !in_array( $param, $aAllOptions )){
			$param = 'all';
		}
		
		switch( $param ){
			case 'other':
				$sql .= " AND city_lang NOT IN ('". implode( "', '", $this->aAvailableLanguages ) ."')";
			break;
			case 'all':	break;
			default:
				$sql .= " AND city_lang = '".$param."'";
			break;
		}
		
		$sql .= " GROUP BY creation_date ORDER BY city_created";
		$oSource->setQuery( $sql );

		$oReport = F::build( 'SponsorshipDashboardReport' );
		$oReport->name = wfMsg( 'newwikisgraph-report-title' );

		$oReport->setLastDateUnits( 30 );
		$oReport->frequency = SponsorshipDashboardDateProvider::SD_FREQUENCY_DAY;

		$oReport->tmpSource = $oSource;
		$oReport->acceptSource();

                $oReport->setId( 0 );
                $oReport->lockSources();

		$oOutput = F::build( 'SponsorshipDashboardOutputChart' );
		$oOutput->set( $oReport );

		$sReturnChart = $oOutput->getHTML();

		$oTmpl = F::build( 'EasyTemplate', array( dirname( __FILE__ ) . "/templates/" ) );
		$oTmpl->set_vars(
			array(
				"tabs"		=> $this->aAvailableLanguages,
				"other"		=> $this->aAvailableOtherOptions,
				"active"	=> $param,
				"path"		=> F::app()->wg->title->getFullURL()
			)
		);
		F::app()->wg->out->addHTML( $oTmpl->execute( "metrics-menu" ) );
		F::app()->wg->out->addHTML( $sReturnChart );
	}
}
