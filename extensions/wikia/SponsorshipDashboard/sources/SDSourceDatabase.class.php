<?php

/**
 * SponsorshipDashboardSourceDatabase
 * @author TOR
 */
class SponsorshipDashboardSourceDatabase extends SponsorshipDashboardSource {

	var $mDatabase = null;
	var $sQuery = '';
	var $sName = '';

	public function __construct( $name ) {

		$this->sName = $name;
		$this->iNumberOfXGuideLines = 7;
		$this->App = WF::build('App');
		$this->frequency = SponsorshipDashboardDateProvider::getProvider();
		
	}

	public function setDatabase( $dbr ) {
		$this->mDatabase = $dbr;
	}

	public function getDatabase() {
		return $this->mDatabase;
	}

	public function setQuery( $query ) {
		$this->sQuery = $query;
	}

	/*
	 * Returns canss DB identifier.
	 *
	 * @return string
	 */

	public function getSourceKey() {
		return $this->sName;
	}

	public function setFrequency( $frequency ) {

		$this->frequency = SponsorshipDashboardDateProvider::getProvider( $frequency );
	}

	/*
	 * Returns source memcache key. Key is built from varaibles specyfic for current serie.
	 *
	 * @return string
	 */

	public function getCacheKey() {

		return self::SD_MC_KEY_PREFIX . ':' . $this->sName;
	}

	/*
	 * Generates data on SQL basis.
	 *
	 * @return void
	 */

	protected function loadData() {

		if ( !$this->dataLoaded ) {

			$this->getResults();
			$this->dataLoaded = true;
		}
	}


        protected function recalculateDateVariables() {

		$this->endDate = $this->frequency->getEndDate();
		$this->startDate = $this->frequency->getStartDate( $this->lastDateUnits );

        }

	protected function getResults() {
		$this->recalculateDateVariables();

		if ( !$this->loadDataFromCache() ) {

			$this->recalculateDateVariables();

			$sql = sprintf( $this->sQuery, $this->startDate, $this->endDate );
			
			$dbr = $this->getDatabase();

			$res = $dbr->query( $sql, __METHOD__ );
			
			while ( $row = $res->fetchObject( $res ) ) {
				$sDate = $row->creation_date;
				$this->dataAll[ $sDate ][ 'date' ] = $sDate;
				$this->dataAll[ $sDate ][ 'a'.md5( $this->serieName ) ] = $row->number;
			}
			$this->dataTitles[ 'a'.md5( $this->serieName ) ] = $this->serieName;

			$this->saveDataToCache();
		}
		$numberOfRecords = count( $this->dataAll );
		if ( is_array( $this->dataAll ) && !empty( $this->lastDateUnits ) ){
			sort( $this->dataAll );
			$this->dataAll = array_slice( $this->dataAll, $numberOfRecords - $this->lastDateUnits );
		}
	}

	/*
	 * Returns array filled with params names and values. Used for saving and filling forms.
	 *
	 * @return array 'paramName' => 'paramValue'
	 */

	protected function getLocalParamsArray() {
		$aData = array();

		$aData[ self::SD_SERIE_NAME ] = $this->serieName;
		
		return $aData;
	}
	
	/*
	 * Fills object from array. Used when creating object from form results.
	 *
	 * @return string - url
	 */

	public function fillFromArray( $aParams ) {

		$this->setGeneralParamsFromArray( $aParams );
	}

	public function validFrequency( $frequency ) {
		return in_array(
			$frequency,
			array(
			    SponsorshipDashboardDateProvider::SD_FREQUENCY_DAY,
			)
		);
	}
}
