<?php

/**
 * SponsorshipDashboard
 * @author Jakub "Szeryf" Kurcek
 *
 * Date provider class control proper date settings for series object.
 */

class SponsorshipDashboardDateProviderMonth {

	const SD_START_DATE = '2010-04';


	public function getType(){
		return SponsorshipDashboardDateProvider::SD_FREQUENCY_MONTH;
	}

	public function getGapiEndDate(){

		return date("Y-m-d", mktime(0, 0, 0, date( "m" ), 0, date( "Y" )));
	}

	public function getGapiStartDate( $dateUnits = 0 ){

		return ( !empty( $dateUnits ) ) ? date("Y-m-d", mktime(0, 0, 0, ( date( "m" )-$dateUnits ), 0 , date( "Y" ))) : SponsorshipDashboardDateProvider::SD_START_DATE;
	}

	public function getGapiDateFromResult( $result ){

		$aDate = array();
		$aDate[] = $result->getYear();
		$aDate[] = $result->getMonth();
		
		return implode( '-', $aDate );
	}

	public function getGapiSortingDate(){

		return array( '-month', '-year' );		
	}
	
	public function getGapiDateDimensionsTable(  ){
		
		return array( 'month', 'year' );
	}

	public function getMobileDateString( $forWhere = false ){

		return ( $forWhere ) ? "DATE_FORMAT( ts, '%Y%m' )" : "DATE_FORMAT( ts, '%Y-%m' )";
	}

	function getEndDate(){
		return date("Y-m", mktime(0, 0, 0, date( "m" ), 0, date( "Y" )));
	}

	function getStartDate(){
		return ( !empty( $dateUnits ) ) ? date("Y-m", mktime(0, 0, 0, ( date( "m" )-$dateUnits ), 0 , date( "Y" ))) : self::SD_START_DATE;
	}
}

class SponsorshipDashboardDateProviderYear {

	public function getType(){
		return SponsorshipDashboardDateProvider::SD_FREQUENCY_YEAR;
	}

	public function getGapiEndDate(){

		return date("Y-m-d", mktime(0, 0, 0, 1, 1, date( "Y" )));
	}

	public function getGapiStartDate( $dateUnits = 0 ){

		return ( !empty( $dateUnits ) ) ? date("Y-m-d", mktime(0, 0, 0, 0, 0 , date( "Y" ) - $dateUnits )) : SponsorshipDashboardDateProvider::SD_START_DATE;
	}

	public function getGapiDateFromResult( $result ){

		$aDate = array();
		$aDate[] = $result->getYear();

		return implode( '-', $aDate );
	}

	public function getGapiSortingDate(){

		return array( '-year' );
	}

	public function getGapiDateDimensionsTable(  ){

		return array( 'year' );
	}

	public function getMobileDateString( $forWhere = false ){

		return ( $forWhere ) ? "DATE_FORMAT( ts, '%Y' )" : "DATE_FORMAT( ts, '%Y' )";
	}

	function getEndDate(){
		return $this->getGapiEndDate();
	}

	function getStartDate(){
		return $this->getGapiStartDate();
	}
}

class SponsorshipDashboardDateProviderDay {

	public function getType(){
		return SponsorshipDashboardDateProvider::SD_FREQUENCY_DAY;
	}
	
	public function getGapiEndDate(){

		return date("Y-m-d", mktime(0, 0, 0, date( "m" ), date( "d" )-1, date( "Y" )));
	}

	public function getGapiStartDate( $dateUnits = 0 ){

		return ( !empty( $dateUnits ) ) ? date("Y-m-d", mktime(0, 0, 0, date( "m" ), date( "d" )-1-$dateUnits, date( "Y" ))) : SponsorshipDashboardDateProvider::SD_START_DATE;
	}

	public function getGapiDateFromResult( $result ){

		$aDate = array();
		$aDate[] = $result->getYear();
		$aDate[] = $result->getMonth();
		$aDate[] = $result->getDay();

		return implode( '-', $aDate );
	}

	public function getGapiSortingDate(){

		return array( '-day', '-month', '-year' );
	}

	public function getGapiDateDimensionsTable(){

		return array( 'day', 'month', 'year' );
	}

	public function getMobileDateString( $forWhere = false ){

		return ( $forWhere ) ? "DATE_FORMAT( ts, '%Y%m%d' )" : "DATE_FORMAT( ts, '%Y-%m-%d' )";
	}

	function getEndDate(){
		return $this->getGapiEndDate();
	}

	function getStartDate(){
		return $this->getGapiStartDate();
	}

	
}

class SponsorshipDashboardDateProvider {

	const SD_FREQUENCY_DAY = 0;
	const SD_FREQUENCY_MONTH = 1;
	const SD_FREQUENCY_YEAR = 2;
	const SD_START_DATE = '2010-04-01';

	public static function getProvider( $kind = self::SD_FREQUENCY_DAY ){

		switch ( $kind ){
			case self::SD_FREQUENCY_YEAR : $className = 'SponsorshipDashboardDateProviderYear'; break;
			case self::SD_FREQUENCY_DAY : $className = 'SponsorshipDashboardDateProviderDay'; break;
		 	default: $className = 'SponsorshipDashboardDateProviderMonth';  break;
		}

		return new $className();
	}
}
