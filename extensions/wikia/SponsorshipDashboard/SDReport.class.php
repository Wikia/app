<?php

/**
 * SponsorshipDashboard
 * @author Jakub "Szeryf" Kurcek
 *
 * Basic report object. Contains source objects. Has some factory functionalities.
 */

class SponsorshipDashboardReport {

	const SD_RETURNPARAM_TICKS = 'ticks';
	const SD_RETURNPARAM_FULL_TICKS = 'fullTicks';
	const SD_RETURNPARAM_SERIE = 'serie';
	const SD_GAPI_RETRIES = 4;

	const SD_SOURCE_GAPI = 'SponsorshipDashboardSourceGapi';
	const SD_SOURCE_GAPI_CUSTOM = 'SponsorshipDashboardSourceGapiCu';
	const SD_SOURCE_STATS = 'SponsorshipDashboardSourceStats';
	const SD_SOURCE_ONEDOT = 'SponsorshipDashboardSourceOneDot';
	const SD_SOURCE_MOBILE = 'SponsorshipDashboardSourceMobile';

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

		$this->App = WF::build('App');
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

		$deserializedData = unserialize( $serializedData );
		
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

		$db = wfGetDB( DB_MASTER, array(), SponsorshipDashboardService::getDatabase() );

		if( !empty( $this->id ) ){

			$db->update(
				'specials.wmetrics_report',
				$this->getTableFromParams(),
				array( 'wmre_id' => (int) $this->id ),
				__METHOD__
			);
		} else {

			$db->insert(
				'specials.wmetrics_report',
				$this->getTableFromParams(),
				__METHOD__
			);
			$this->sourceId = $db->insertId();
			$this->setId( $db->insertId() );
			$db->commit();
		}		
		$this->saveSources();
	}

	public function delete(){
		
		if( !empty( $this->id ) ){
			$db = wfGetDB( DB_MASTER, array(), SponsorshipDashboardService::getDatabase() );
			$db->delete(
				'specials.wmetrics_report',
				array( 'wmre_id' => $this->id )
			);
			$this->setId( 0 );
		}
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

		$array = array(
		    'wmre_id'		=> ( int )$this->id,
		    'wmre_name'		=>  $this->name ,
		    'wmre_description'	=>  $this->description,
		    'wmre_steps'	=> ( int )$this->dateUnits,
		    'wmre_frequency'	=> ( int )$this->frequency
		);

		return $array;
	}

	public function saveSources(){
		
		$db = wfGetDB( DB_MASTER, array(), SponsorshipDashboardService::getDatabase() );
		$db->delete(
			'specials.wmetrics_source',
			array( 'wmso_report_id' => $this->id )
		);
		foreach( $this->reportSources as $source ){
			if( is_object( $source ) ){
				$source->save( $this->id );
			}
		}
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
		$aParams['id'] = $this->id;
		$aParams[ SponsorshipDashboardSource::SD_PARAMS_FREQUENCY ] = $this->frequency;
		$aParams['name'] = $this->name;
		$aParams['description'] = $this->description;
		$aParams[ SponsorshipDashboardSource::SD_PARAMS_LASTUNITDATE ] = $this->dateUnits;

		return $aParams;
	}

	public function loadReportParams(){

		if( empty( $this->id ) ){
			return false;
		}

		$dbr = wfGetDB( DB_SLAVE, array(), SponsorshipDashboardService::getDatabase() );
		$res = $dbr->select(
			'specials.wmetrics_report',
			array(
			    'wmre_id as id',
			    'wmre_name as name',
			    'wmre_description as description',
			    'wmre_frequency as frequency',
			    'wmre_steps as steps'
			),
			array( 'wmre_id = '. $this->id ),
			__METHOD__,
			array()
		);

		$returnArray = array();
		while ( $row = $res->fetchObject( $res ) ) {
			$this->description = ( $row->description );
			$this->name = ( $row->name );
			$this->frequency = ( $row->frequency );
			$this->setLastDateUnits( $row->steps );
		}
	}

	public function loadSources(){

		if( empty( $this->id ) ){
			return false;
		}

		if( $this->sourcesLoaded ){
			return true;
		}

		$this->sourcesLoaded = true;
		$dbr = wfGetDB( DB_SLAVE, array(), SponsorshipDashboardService::getDatabase() );
		$res = $dbr->select(
			'specials.wmetrics_source',
			array( 'wmso_id as id', 'wmso_type as type' ),
			array( 'wmso_report_id = '. $this->id ),
			__METHOD__,
			array()
		);

		$returnArray = array();
		while ( $row = $res->fetchObject( $res ) ) {
			$this->newSource(
				SponsorshipDashboardSource::sourceClassFromDBKey( $row->type )
			);
			if ( in_array( get_class( $this->tmpSource ), $this->availableSources )){
				$this->tmpSource->sourceId = $row->id;
				$this->tmpSource->loadSource();
				$this->acceptSource( $this->getCitiesList( $this->tmpSource ) );
			}
		}

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
		};
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
	 * Returns list of hubs prepared to be used in chart display
	 *
	 * @return array
	 */

	// 2DO: Move to output provider ?
	// Notice: Never used
	
	public function getGeneralHubList(){

		$wgExternalSharedDB = $this->App->getGlobal( 'wgExternalSharedDB' );
		$wgHubsPages = $this->App->getGlobal('wgHubsPages');

		if ( empty( $wgHubsPages ) || !is_array( $wgHubsPages ) || !isset( $wgHubsPages['en'] ) ){
			return array();
		}
		
		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$res = $dbr->query( 'SELECT id, name FROM city_tag', __METHOD__);
		$returnArray = array();

		while ( $row = $res->fetchObject( $res ) ) {
			foreach ( $wgHubsPages['en'] as $hubPage ){
				if ( $hubPage['name'] == $row->name ){
					$returnArray[ $row->id ] = $row->name;
				}
			}
		}
		return $returnArray;
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

		if ( empty( $number ) ){
			$number = 10;
		}
		
		$wgStatsDB = $this->App->getGlobal('wgStatsDB');
		$returnArray = array();

		// never use current data. use data from last week.
		
		$week = date( "YW", strtotime( "-1 week" ) );
		
		$week = '201101';
		
		$cityId = (int) $cityId;
		if ( empty( $cityId ) ){
			$cityId = $this->App->getGlobal('wgCityId');
		}

		$number = (int)$number;
		if ( $number < 0 ) {
			$number = 10;
		}

		$dbr = wfGetDB( DB_SLAVE, array(), $wgStatsDB );

		if ( empty( $hubId ) ){

			$sql = "SELECT t2.pv_city_id as cityId, count(t1.pv_user_id) AS citycommonusers
				FROM page_views_weekly_user AS t1
				INNER JOIN page_views_weekly_user AS t2
					ON t1.pv_user_id = t2.pv_user_id
					AND t1.pv_week = t2.pv_week
				WHERE t1.pv_city_id = {$cityId} AND t1.pv_week = {$week}
				GROUP BY t2.pv_city_id
				ORDER BY citycommonusers DESC
				LIMIT ".( $number + 1 );
		} else {

			$currentHub = (int) $hubId;
			
			$sql1 ="SELECT pv_city_id as cityId, count(pv_user_id) AS citycommonusers
				FROM page_views_weekly_user
				WHERE pv_week = {$week} AND pv_city_id = {$cityId}";

			$sql = "SELECT t2.pv_city_id as cityId, count(t1.pv_user_id) AS citycommonusers
				FROM page_views_weekly_user AS t1
				INNER JOIN page_views_weekly_user AS t2
					ON t1.pv_user_id = t2.pv_user_id
					AND t1.pv_week = t2.pv_week
				INNER JOIN wikicities.city_tag_map AS ctm
					ON ctm.city_id = t2.pv_city_id
					AND ( ctm.tag_id = {$hubId} )
				WHERE t1.pv_city_id = {$cityId} AND t1.pv_week = {$week}
				GROUP BY t2.pv_city_id
				ORDER BY citycommonusers DESC
				LIMIT ".( $number );

			$res1 = $dbr->query( $sql1, __METHOD__ );
			while ( $row = $res1->fetchObject( $res1 ) ) {
				$returnArray[] = $row->cityId;
			}
		}

		$res = $dbr->query( $sql, __METHOD__ );

		while ( $row = $res->fetchObject( $res ) ) {
			$returnArray[] = $row->cityId;
		}

		return $returnArray;
	}
}