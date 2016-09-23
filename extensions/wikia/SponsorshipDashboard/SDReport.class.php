<?php

/**
 * SponsorshipDashboard
 * @author Jakub "Szeryf" Kurcek
 *
 * Basic report object. Contains source objects. Has some factory functionalities.
 */

class SponsorshipDashboardReport {

	const SD_RETURNPARAM_TICKS	= 'ticks';
	const SD_RETURNPARAM_FULL_TICKS = 'fullTicks';
	const SD_RETURNPARAM_SERIE	= 'serie';
	const SD_GAPI_RETRIES		= 4;

	const SD_SOURCE_GAPI		= 'SponsorshipDashboardSourceGapi';
	const SD_SOURCE_GAPI_CUSTOM	= 'SponsorshipDashboardSourceGapiCu';
	const SD_SOURCE_STATS		= 'SponsorshipDashboardSourceStats';
	const SD_SOURCE_ONEDOT		= 'SponsorshipDashboardSourceOneDot';
	const SD_SOURCE_MOBILE		= 'SponsorshipDashboardSourceMobile';

	const SD_PARAMS_ID		= 'id';
	const SD_PARAMS_NAME		= 'name';
	const SD_PARAMS_DESCRIPTION	= 'description';

	protected $availableSources = array( self::SD_SOURCE_GAPI, self::SD_SOURCE_GAPI_CUSTOM, self::SD_SOURCE_STATS, self::SD_SOURCE_ONEDOT, self::SD_SOURCE_MOBILE );
	protected $iNumberOfXGuideLines = 7;
	protected $dateUnits = false;
	protected $App = null;
	protected $sourcesLoaded = false;

	public $id = 0;
	public $reportSources = array();
	public $frequency;
	public $name = '';
	public $description = '';
	public $tmpSource = null;

	public function __construct( $id = 0 ){

		$this->App = F::app();
		$this->setId( $id );
	}

	public function getNumberOfXGuideLines(){
		return $this->iNumberOfXGuideLines;
	}

	private function isValidSource( $source ){

		return true;
	}

	/*
	 * Returns an array of all cities mentioned in source objects.
	 * Source objects can have fixed lists od fynamic ( from TOP X neighbours )
	 *
	 * @return aray
	 */

	public function getCitiesList( $source ){

		if ( $source->sourceType == SponsorshipDashboardSource::SD_SOURCE_LIST ){
			return $source->repeatFromList;
		} else {
			$return = $this->getCurrentTopXRelatedCities(
				$source->repeatFromCompetitorsTopX,
				$source->repeatFromCompetitorsCityId,
				$source->repeatFromCompetitorsHubId
			);
			return $return;
		}
	}

	/*
	 * Receives formatted form return and distributes it among report params and serie objects )
	 *
	 * @return void
	 */

	public function fillFromSerializedData( $serializedData ){

		Wikia::log( __METHOD__, 'Depreciated?' );

		$deserializedData = unserialize( $serializedData, [ 'allowed_classes' => false ] );

		parse_str( $deserializedData[0], $mainSerie );
		if ( isset( $mainSerie[ SponsorshipDashboardSource::SD_PARAMS_LASTUNITDATE ] ) ){
			$this->setLastDateUnits( ( int )$mainSerie[ SponsorshipDashboardSource::SD_PARAMS_LASTUNITDATE ] );
		}

		if ( isset( $mainSerie['mainTitle'] ) ){
			$this->name = stripslashes( $mainSerie['mainTitle'] );
		}

		if ( isset( $mainSerie['mainDescription'] ) ){
			$this->description = stripslashes( $mainSerie['mainDescription'] );
		}

		if ( isset( $mainSerie['mainId'] ) ){
			$this->id = $mainSerie['mainId'];
		}

		if ( isset( $mainSerie[ SponsorshipDashboardSource::SD_PARAMS_FREQUENCY ] ) ){

			if (
				in_array(
					$mainSerie[ SponsorshipDashboardSource::SD_PARAMS_FREQUENCY ],
					array( SponsorshipDashboardDateProvider::SD_FREQUENCY_MONTH, SponsorshipDashboardDateProvider::SD_FREQUENCY_DAY )
				)
			){
				$this->frequency = $mainSerie[ SponsorshipDashboardSource::SD_PARAMS_FREQUENCY ];
			} else {
				$this->frequency = SponsorshipDashboardDateProvider::SD_FREQUENCY_MONTH;
			}
		}

		foreach ( $deserializedData as $serie ){

			parse_str( $serie, $serie );
			$serie[ SponsorshipDashboardSource::SD_PARAMS_FREQUENCY ] = $this->frequency;
			if ( isset( $serie['sourceType'] ) && $this->isValidSource( $serie['sourceType'] )  ){
				if (
					$this->newSource(
						SponsorshipDashboardSource::sourceClassFromDBKey( $serie['sourceType'] )
					)
				){
					$this->tmpSource->fillFromArray( $serie );
					$this->acceptSource( $this->getCitiesList( $this->tmpSource ) );
				}
			}
		}
	}

	public function lockSources(){
		$this->sourcesLoaded = true;
	}

	/*
	 * Saves eport and all sources to DB.
	 *
	 * @return void
	 */

	public function save(){

		Wikia::log( __METHOD__, 'Depreciated' );
	}

	public function delete(){

		Wikia::log( __METHOD__, 'Depreciated' );
	}

	public function setId( $id ){

		if ( (int)$id >= 0 ){
			$this->id = (int)$id;
			foreach( $this->reportSources as & $reportSource ){
				$reportSource->setReportId( $this->id );
			}
		}
	}

	/*
	 * Returns object params as an array prepared to be saved into db
	 *
	 * @return array
	 */

	public function getTableFromParams(){

		Wikia::log( __METHOD__, 'Depreciated' );
	}

	public function saveSources(){

		Wikia::log( __METHOD__, 'Depreciated' );
	}

	public function getProgress(){

		$wgMemc = $this->App->getGlobal('wgMemc');
		$progress = $counter = 0;
		foreach( $this->reportSources as $source ){
			$result = $wgMemc->get( $source->getCacheKey() );
			$progress = ( !empty( $result ) ) ? $progress + 1 : $progress;
			$counter++;
		}

		return ( $counter == 0 ) ? 100 : ceil( $progress / $counter * 100 );
	}

	// builds array with filled forms;
	public function getMenuItemsHTML(){

		$this->loadSources();
		$returnArray = '';

		foreach ( $this->reportSources as $source ){
			if ( $source->isSaveable() ){
				$returnArray[] = $source->getFormHTML();
			}
		}

		return $returnArray;
	}

	/*
	 * Returns object params as an array
	 *
	 * @return array
	 */

	public function getReportParams(){

		$aParams = array();
		$aParams[ SponsorshipDashboardReport::SD_PARAMS_ID ] = $this->id;
		$aParams[ SponsorshipDashboardSource::SD_PARAMS_FREQUENCY ] = $this->frequency;
		$aParams[ SponsorshipDashboardReport::SD_PARAMS_NAME ] = $this->name;
		$aParams[ SponsorshipDashboardReport::SD_PARAMS_DESCRIPTION ] = $this->description;
		$aParams[ SponsorshipDashboardSource::SD_PARAMS_LASTUNITDATE ] = $this->dateUnits;

		return $aParams;
	}

	public function loadReportParams(){

		Wikia::log( __METHOD__, 'Depreciated' );
	}

	public function loadSources(){

		Wikia::log( __METHOD__, 'Depreciated' );
	}

	public function setLastDateUnits( $number ){

		if ( (int)$number <= 0 ){
			$this->dateUnits = 0;
		} else {
			$this->dateUnits = (int) $number;
		}
	}

	public function addSource( $objSource ){

		if ( is_object( $objSource ) && $objSource instanceof SponsorshipDashboardSource ){
			$objSource->setLastDateUnits( $this->dateUnits );
			$newObject = clone $objSource;
			$this->reportSources[] = $newObject;
			return true;
		};
		return false;
	}

	/*
	 * Calls data provider.
	 *
	 * @return string - html
	 */

	public function returnChartData(){

		$this->loadSources();
		$oOutput = SponsorshipDashboardOutputChart::newFromReport( $this );
		return $oOutput->getChartData();
	}

	public function newSource( $sourceKind , $id = 0 ){

		if ( in_array( $sourceKind, $this->availableSources ) ){
			$tmpSource = new $sourceKind( $id );
			if ( $tmpSource->validFrequency( $this->frequency ) ){
				$this->tmpSource = $tmpSource;
				return true;
			}
		}
		$this->tmpSource = null;
		return false;
	}

	/*
	 * After creating and filling with data source should be accepted.
	 * This method moves tha object from tmpSlot to sources aray.
	 *
	 * @param array $multipleForCityIds as source displays data for only
	 * one cityId sources are miltiplied for every city in array,
	 * but with te same parameters.
	 * Multiplied sources will not be saved into DB
	 *
	 * @return void
	 */

	public function acceptSource( $multipleForCityIds = false ){

		if ( is_array( $multipleForCityIds ) && !empty( $multipleForCityIds ) ){
			$first = true;
			foreach ( $multipleForCityIds as $cityId ){
				$this->tmpSource->setCityId( $cityId );
				$this->tmpSource->setReportId( $this->id );
				$this->tmpSource->setSaveable( $first );
				$this->addSource( $this->tmpSource );
				$first = false;
			}
		} else {
			$this->addSource( $this->tmpSource );
		}

		$this->tmpSource = null;
	}

	/*
	 * Sets id for current source. If source has no id it will be considered new.
	 *
	 * @param int $number number of neighbours that we want to display.
	 *
	 * @param int $cityId neighbours of the specified city.
	 * If no city specified then current city will be used.
	 *
	 * @param int $hubId id of hub from which we want to seek for neighbours.
	 * If no hubId specified then method will perform global search.
	 *
	 * @return array
	 */

	public function getCurrentTopXRelatedCities( $number = false, $cityId = false, $hubId = false ){

		Wikia::log( __METHOD__, 'Depreciated' );

		return false;
	}
}
