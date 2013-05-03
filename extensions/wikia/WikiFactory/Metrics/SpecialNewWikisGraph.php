<?php

class NewWikisGraphSpecialPageController extends WikiaSpecialPageController {

	private $aAvailableLanguages = array( 'en', 'de', 'es', 'fr', 'it', 'ja', 'nl', 'no', 'pl', 'pt', 'pt-br', 'ru', 'zh' );
	private $aAvailableOtherOptions = array( 'other', 'all' );

	public function __construct() {
            parent::__construct( 'NewWikisGraph', 'wikifactorymetrics' /* restriction */ );
	}

	public function execute( $param ) {
            $this->setHeaders();

            $oOutput = (new SpecialNewWikisGraphOutput);

            $endDate = new DateTime( date( 'Y-m-d' ) );
            $endDate->sub( new DateInterval( 'P1D' ) );
            $startDate = clone $endDate;
            $startDate->sub( new DateInterval( 'P1M' ) );

            $oOutput->set( $this->getReport( $startDate, $endDate, $param ) );

            $aAllOptions = array_merge( $this->aAvailableLanguages, $this->aAvailableOtherOptions );
            $param = ( in_array( $param, $aAllOptions ) ? $param : '' );

            $oOutput->setActive( $param );

            $sReturnChart = $oOutput->getHTML();

            $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );

            $oTmpl->set_vars(
                    array(
                        "tabs"		=> $this->aAvailableLanguages,
                        "other"		=> $this->aAvailableOtherOptions,
                        "active"	=> $param,
                        "path"		=> F::app()->wg->title->getFullURL()
                    )
            );

            F::app()->wg->out->addHTML( $oTmpl->render( "metrics-menu" ) );
            F::app()->wg->out->addHTML( $sReturnChart );
	}

        private function getReport( $startDate, $endDate, $param ) {
            $oReport = (new SponsorshipDashboardReport);
            $oReport->name = wfMsg( 'newwikisgraph-report-title' );
            $oReport->frequency = SponsorshipDashboardDateProvider::SD_FREQUENCY_DAY;
            $oReport->tmpSource = $this->getSource( $startDate, $endDate, $param );
            $oReport->setLastDateUnits( $startDate->diff( $endDate )->days );
            $oReport->acceptSource();
            $oReport->setId( 0 );
            $oReport->lockSources();
            return $oReport;
        }

        private function getSource( $startDate, $endDate, $param ) {
            $aAllOptions = array_merge( $this->aAvailableLanguages, $this->aAvailableOtherOptions );
            $param = ( in_array( $param, $aAllOptions ) ? $param : '' );

            $oSource = new SpecialNewWikisGraphSourceDatabase( 'wikicreations' . $param );
            $oSource->serieName = wfMsg( 'newwikisgraph-wikis-created' );
            $oSource->setDatabase( wfGetDB( DB_SLAVE, array(), F::app()->wg->externalSharedDB ) );

            $sql = "SELECT count(city_id) as number, DATE( city_created ) as creation_date
                FROM city_list
                WHERE city_created >= '%s'
                AND city_created <= '%s'";

            if ( !in_array( $param, $aAllOptions ) ) {
                $param = 'all';
            }

            switch( $param ) {
                case 'other':
                    $sql .= " AND city_lang NOT IN ('". implode( "', '", $this->aAvailableLanguages ) ."')";
                    break;
                case 'all':
                    break;
                default:
                    $sql .= " AND city_lang = '".$param."'";
                    break;
            }

            $sql .= " GROUP BY creation_date ORDER BY city_created";

            $oSource->setQuery( $sql );
            $oSource->setStartDate( $startDate->format( 'Y-m-d' ) );
            $oSource->setEndDate( $endDate->format( 'Y-m-d' ) );

            return $oSource;
        }

        public function getData() {
            $inStartDate = $this->getVal( 'startDate', date( 'Y-m-d' ) );
            $inEndDate = $this->getVal( 'endDate', date( 'Y-m-d' ) );
            $inParam = $this->getVal( 'param', '' );

            $aAllOptions = array_merge( $this->aAvailableLanguages, $this->aAvailableOtherOptions );
            $inParam = ( in_array( $inParam, $aAllOptions ) ? $inParam : '' );

            $startDate = DateTime::createFromFormat( 'Y-m-d', $inStartDate );
            $endDate = DateTime::createFromFormat( 'Y-m-d', $inEndDate );

            unset( $inStartDate, $inEndDate );

            if ( !$startDate || !$endDate ) {
                $endDate = new DateTime( date( 'Y-m-d' ) );
                $endDate->sub( new DateInterval( 'P1D' ) );
                $startDate = clone $endDate;
                $startDate->sub( new DateInterval( 'P1M' ) );
            }

            $oOutput = (new SpecialNewWikisGraphOutput);
            $oOutput->set( $this->getReport( $startDate, $endDate, $inParam ) );

            $mOut = $oOutput->getRaw();

            $this->setVal('chartId', $mOut->chartId );
            $this->setVal('datasets', $mOut->datasets );
            $this->setVal('fullTicks', $mOut->fullTicks );
            $this->setVal('hiddenSeries', $mOut->hiddenSeries );
            $this->setVal('monthly', $mOut->monthly );
            $this->setVal('ticks', $mOut->ticks );
        }
}
