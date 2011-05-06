<?php
/**
 * SponsorshipDashboard
 * @author Jakub "Szeryf" Kurcek
 *
 * OneDot source.
 */

class SponsorshipDashboardSourceOneDot extends SponsorshipDashboardSource {

	const SD_START_DATE = '201047';
	const SD_SOURCE_TYPE = 'OneDot';

	const SD_PARAMS_ONEDOT_CITY_ID = 'masterCityId';

	protected $masterCityId = false;
	protected $startDate = false;
	protected $endDate = false;	

	// ============================

	public function __construct(){

		parent::__construct();
		$this->masterCityId = $this->App->getGlobal('wgCityId');;
	}

	/*
	 * Returns calss DB identifier.
	 *
	 * @return string
	 */

	public function getSourceKey(){
		return 'OneDot';
	}

	/*
	 * Returns source memcache key. Key is built from varaibles specyfic for current serie.
	 *
	 * @return string
	 */

	public function getCacheKey(){

		$aKey = array();

		$aKey[] = $this->cityId;
		$aKey[] = $this->cityIdForced;
		$aKey[] = $this->lastDateUnits;

		$akey[] = $this->masterCityId;
		$aKey[] = $this->endDate;
		$aKey[] = $this->startDate;

		return self::SD_MC_KEY_PREFIX.':'.self::SD_SOURCE_TYPE.':'.md5(implode( ':', $aKey ));
	}

	/*
	 *  Setters / Getters / Validators
	 */

	public function setMasterCityId( $cityId = false ){

		if ( !empty( $cityId ) ){
			$oCity = WikiFactory::getWikiByID( $cityId );
			if ( is_object( $oCity ) ){
				$cityId = $oCity->city_id;
			} else {
				$cityId = false;
			}
		}

		$this->masterCityId = ( !empty( $cityId ) )
			? $cityId
			: $this->App->getGlobal('wgCityId');
	}

	public function isMasterCityIdLocal(){

		return ( empty( $this->cityIdForced ) );
	}

	public function getMasterCityId(){

		if ( empty( $this->masterCityId ) ){
			$this->setMasterCityId();
		}
		return $this->masterCityId;
	}

	protected function recalculateDateVariables(){

		$this->endDate = date("YW", strtotime("-1 week") );
		$this->startDate = ( !empty( $this->lastDateUnits ) ) ? date( "YW", strtotime( "-".( $this->lastDateUnits + 1 )." weeks" ) ) : self::SD_START_DATE;
	}

	// ============================
	
	public function getData(){

		$this->recalculateDateVariables();
		$this->loadData();
	}

	/*
	 * Fils object from the database.
	 *
	 * @return void
	 */

	protected function loadData(){

		if ( !$this->dataLoaded ){
			$results = $this->getResults();
			$this->dataLoaded = true;
		}
	}

	protected function getResults( ){

		if ( $this->getMasterCityId() == $this->getCityId() ){
			return false;
		};
		if ( !$this->loadDataFromCache() ){

			$aSecondResults = $this->getResultsForCityId( $this->getCityId() );
			$aMainResults = $this->getResultsForCityId( $this->getMasterCityId() );

			$caption = WikiFactory::getWikiByID( $this->getMasterCityId() )->city_title;

			foreach( $aMainResults as $key => $val ){

				$totalMainNumber = count( $aMainResults[ $key ] );
				$totalCompetitors = 0;
				foreach( $val as $city ){
					if ( isset( $aSecondResults[ $key ] ) && is_array( $aSecondResults[ $key ] ) ){
						if ( in_array( $city, $aSecondResults[ $key ] ) ){
							$totalCompetitors++;
						}
					}
				}
				$this->dataAll[ $key ][ 'a'.md5( $this->getMasterCityId().'|'.$this->getCityId() ) ] = $totalCompetitors / $totalMainNumber * 100;
				$this->dataAll[ $key ][ self::SD_DATE_CELL ] = $key;
			}

			$this->dataTitles[ 'a'.md5( $this->getMasterCityId().'|'.$this->getCityId() ) ] = WikiFactory::getWikiByID( $this->getCityId() )->city_title;
			$this->saveDataToCache();
			
		}
		return true;
		
	}

	/*
	 * As this source compares two results we are caching every result to minimize DB requests number.
	 *
	 * @return void
	 */

	protected function getResultsForCityId( $iCityId ){

		$wgMemc = $this->App->getGlobal('wgMemc');
		$memcData = $wgMemc->get( $this->getLocalMCKey( $iCityId ) );

		if ( !empty( $memcData ) ){
			return $memcData;
		}

		$wgStatsDB = $this->App->getGlobal('wgStatsDB');
		$returnArray = array();

		$sql = "SELECT t1.pv_user_id, t1.pv_week
			FROM page_views_weekly_user AS t1
			WHERE t1.pv_city_id = {$iCityId}
			  AND t1.pv_week >= {$this->startDate}
			  AND t1.pv_week <= {$this->endDate}
			ORDER BY t1.pv_week";

		$dbr = wfGetDB( DB_SLAVE, array(), $wgStatsDB );
		$res = $dbr->query( $sql, __METHOD__ );

		$result = array();
		while ( $row = $res->fetchObject( $res ) ) {
			$sDate = date("Y-m-d", strtotime("1.1.".substr( $row->pv_week, 0, 4 )." + ".substr( $row->pv_week, 4, 2 )." weeks"));
			if ( !isset( $result[ $sDate ] ) ){
				$result[ $sDate ] = array();
			}
			$aRow = $result[ $sDate ];
			if ( empty( $aRow ) ){
				$result[ $sDate ] = array( $row->pv_user_id );
			} else {
				$result[ $sDate ][] = $row->pv_user_id;
			}
		}

		if ( !empty( $result ) ) {
			$wgMemc->set(
				$this->getLocalMCKey( $iCityId ),
				$result,
				( strtotime('tomorrow') - time() )
			);
		}

		return $result;
	}

	protected function getLocalMCKey( $iCityId ){
		return 'SponsorshipDashboard:OneDotCityResult:'.$iCityId;
	}

	/*
	 * Returns array filled with params names and values. Used for saving and filling forms.
	 *
	 * @return array 'paramName' => 'paramValue'
	 */

	protected function getLocalParamsArray() {
	
		$aData = array();
	
		$aData[ self::SD_PARAMS_LASTUNITDATE ] = $this->lastDateUnits;
		$aData[ self::SD_PARAMS_CITYID ] = $this->cityId;
		$aData[ self::SD_PARAMS_CITYIDFORCED ] = $this->cityIdForced;
		$aData[ self::SD_PARAMS_ONEDOT_CITY_ID ] = $this->masterCityId;
		
		return $aData;
	}

	public function getMenuTemplateLink(){

		return '../../templates/editor/addNewOneDot';
	}

	public function fillFromArray( $aParams ){

		if ( isset( $aParams[ self::SD_PARAMS_ONEDOT_CITY_ID ] ) ){
			$this->setMasterCityId( $aParams[ self::SD_PARAMS_ONEDOT_CITY_ID ] );
		}

		$this->setGeneralParamsFromArray( $aParams );
	}

	public function validFrequency( $frequency ){

		return in_array(
			$frequency,
			array(
			    SponsorshipDashboardDateProvider::SD_FREQUENCY_DAY
			)
		);
	}
}
