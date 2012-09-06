<?php

/**
 * SponsorshipDashboard
 * @author Jakub "Szeryf" Kurcek
 *
 * Mother class for managing input sources.
 */

abstract class SponsorshipDashboardSource {

	const SD_RETURNPARAM_TICKS = 'ticks';
	const SD_RETURNPARAM_FULL_TICKS = 'fullTicks';
	const SD_RETURNPARAM_SERIE = 'serie';
	const SD_GAPI_RETRIES = 4;
	const SD_DATE_CELL = 'date';
	const SD_MSG_PREFIX = 'sponsorship-dashboard-serie-';
	const SD_MC_KEY_PREFIX = 'WikiMetrics';

	const SD_SOURCE_LIST = 0;
	const SD_SOURCE_COMPETITORS = 1;
	const SD_SOURCE_GLOBAL = 2;

	// containers

	var $App;
	var $sourceId = 0;
	var $reportId;
	public  $saveable = true;

	// source params

	protected $cityIdForced = false;
	protected $cityId;
	protected $cityPrefix = false;

	protected $lastDateUnits = false;

	public $sourceType = self::SD_SOURCE_LIST;

	public $repeatFromList = array();
	public $repeatFromCompetitorsCityId = false;
	public $repeatFromCompetitorsHubId = false;
	public $repeatFromCompetitorsTopX = false;

	public $dataAll;
	public $dataTitles;
	public $actualDate;
	public $dataLoaded = false;

	public $mStats;
	public $aCityHubs;
	public $iNumberOfXGuideLines = 7;
	public $fromYear = 2001;

	abstract public function getSourceKey();

	abstract protected function recalculateDateVariables();

	abstract public function fillFromArray( $aParams );

	abstract public function validFrequency( $frequency );

	public function __construct( $id = 0 ) {

		$this->App = F::app();
		$this->cityId = $this->App->getGlobal('wgCityId');
		$this->setId( $id );

	}

	/*
	 * Sets id for current source. If source has no id it will be considered new.
	 *
	 * @param int $id source id.
	 *
	 * @return void
	 */

	public function setId( $id ) {

		$this->sourceId = (int)$id;
	}

	/*
	 * Getter for fromYear parameter.
	 *
	 * @param void.
	 *
	 * @return int
	 */

	public function getFromYear() {

		return $this->fromYear;
	}

	/*
	 * Fills object with data.
	 *
	 * @param void.
	 *
	 * @return void
	 */

	public function getData() {

		$this->recalculateDateVariables();
		$this->loadData();
	}

	public function getId() {

		return ( !empty( $this->sourceId ) ) ? $this->sourceId : false;
	}

	/*
	 * Sets id for current report connected with source.
	 *
	 * @param int $id source id.
	 *
	 * @return void
	 */

	public function setReportId( $id ) {

		$this->reportId = (int) $id;
	}

	/*
	 * If set to false serie will not be saved to the database.
	 * Used mailny for duplicated series and series orginating from lists and TOP X competitors..
	 *
	 * @param boolean $saveable new value for saveable parameter.
	 *
	 * @return void
	 */

	public function setSaveable( $saveable = true ) {
		$this->saveable = ( !empty( $saveable ) );
	}

	public function isSaveable() {
		return $this->saveable;
	}

	/*
	 * Setter for CityId for current serie. If not City id then serie will be generated for current wiki.
	 *
	 * @param int $cityId new value for cityId parameter, should be CityId.
	 *
	 * @return void
	 */

	public function setCityId( $cityId = 0 ) {

		if ( !empty( $cityId ) ) {
			$oCity = WikiFactory::getWikiByID( $cityId );
			if ( is_object( $oCity ) ) {
				$cityId = $oCity->city_id;
			} else {
				$cityId = 0;
			}
		}

		$this->cityIdForced = ( !empty( $cityId ) );
		$this->cityId = ( $this->cityIdForced )
			? $cityId
			: $this->App->getGlobal('wgCityId');
	}

	/*
	 * Getter for CityId for current serie.
	 *
	 * @return int cityId
	 */

	public function getCityId() {

		if ( $this->sourceType == self::SD_SOURCE_GLOBAL ) {
			return 0;
		}

		if ( empty( $this->cityId ) ) {
			$this->setCityId();
		}
		return $this->cityId;
	}

	/*
	 * Checkes if cityId was forced or current wiki.
	 *
	 * @return boolean
	 */

	public function isCityIdLocal() {

		return ( empty( $this->cityIdForced ) );
	}

	/*
	 * Gets city prefix before serie name. used for building serie description.
	 *
	 * @return string
	 */

	protected function getCityPrefix() {

		if ( empty( $this->cityPrefix ) ) {
			if ( $this->sourceType == self::SD_SOURCE_GLOBAL ){
				$this->cityPrefix = wfMsg( 'sponsorship-dashboard-source-global').': ';
			} else {
				$this->cityPrefix =
					( $this->isCityIdLocal() )
						? ''
						: WikiFactory::getWikiByID( $this->getCityId() )->city_title.': ';
			}
		}
		return $this->cityPrefix;
	}

	/*
	 * Sets number of date units that will be displayed in chart.
	 *
	 * @param int $number.
	 *
	 * @return void
	 */

	public function setLastDateUnits( $number ) {

		if ( (int)$number <= 0 ) {
			$this->lastDateUnits = 0;
		} else {
			$this->lastDateUnits = (int) $number;
		}
	}

	/*
	 * Saves source to database. WIll not save source that is marked unsaveable
	 * nor source that is not connected to any report.
	 *
	 * @param int $reportId.
	 *
	 * @return void
	 */

	public function save( $reportId ) {
		Wikia::log( __METHOD__, 'JKU', 'saveMe');
		$this->setReportId( $reportId );

		if ( $this->saveable && !empty( $this->reportId ) ) {

			$db = wfGetDB( DB_MASTER, array(), SponsorshipDashboardService::getDatabase() );

			if ( !is_null( $db ) ) {
				$array = array(
						'wmso_type' => $this->getSourceKey(),
						'wmso_report_id' => $this->reportId,
					);

				if( $this->getId() ) {

					$array['wmso_id'] = $this->getId();
					$db->update(
						'specials.wmetrics_source',
						$array,
						array( 'wmso_id' => $this->sourceId ),
						__METHOD__
					);
				} else {
					$array['wmso_id'] = $this->getId();
					$db->insert(
						'specials.wmetrics_source',
						$array,
						__METHOD__
					);
					$this->sourceId = $db->insertId();
				}
				$db->commit();
				$this->saveParams();
			}
		}
		Wikia::log( __METHOD__, 'JKU', 'saveMeEnd');

	}

	/*
	 * Saves source paramseters.
	 *
	 * @param int $reportId.
	 *
	 * @return void
	 */

	protected function saveParams() {

		$db = wfGetDB( DB_MASTER, array(), SponsorshipDashboardService::getDatabase() );

		if ( !is_null( $db ) ) {
			$db->delete(
				'specials.wmetrics_source_params',
				array( 'wmsop_source_id' => $this->sourceId )
			);
			foreach ( $this->getParamsArray() as $param => $value ) {

				$db->insert(
					'specials.wmetrics_source_params',
					array(
						'wmsop_source_id' => $this->sourceId,
						'wmsop_type' => $param,
						'wmsop_value' => $value
					),
					__METHOD__
				);
			}
			$db->commit();
		}
	}

	const SD_PARAMS_REP_CITYID = 'repCityId';
	const SD_PARAMS_REP_COMP_CITYID = 'repCompCityId';
	const SD_PARAMS_REP_COMP_HUBID = 'repCompHubId';
	const SD_PARAMS_REP_TOPX = 'repCompTopX';
	const SD_PARAMS_REP_SOURCE_TYPE = 'repeatSourceType';
	const SD_PARAMS_CITYIDFORCED = 'cityIdForced';
	const SD_PARAMS_CITYID = 'cityId';
	const SD_PARAMS_LASTUNITDATE = 'lastDateUnits';
	const SD_PARAMS_FREQUENCY = 'mainFrequency';

	/*
	 * Returns common source parameters with values.
	 * These parameters are not part of caching key.
	 *
	 * @param int $reportId.
	 *
	 * @return array
	 */

	protected function getGeneralParamsArray() {

		$aData = array();

		$aData[ self::SD_PARAMS_REP_CITYID ] = implode( ',', $this->repeatFromList );
		$aData[ self::SD_PARAMS_REP_COMP_CITYID ] = $this->repeatFromCompetitorsCityId;
		$aData[ self::SD_PARAMS_REP_COMP_HUBID ] = $this->repeatFromCompetitorsHubId;
		$aData[ self::SD_PARAMS_REP_TOPX ] = $this->repeatFromCompetitorsTopX;
		$aData[ self::SD_PARAMS_REP_SOURCE_TYPE ] = $this->sourceType;

		return $aData;
	}

	/*
	 * Fills ofject from form result.
	 *
	 * @param array $aParams.
	 *
	 * @return array
	 */

	protected function setGeneralParamsFromArray( $aParams ) {

		if ( isset( $aParams[ self::SD_PARAMS_REP_CITYID ] ) ) {
			$this->repeatFromList = explode( ',', $aParams[ self::SD_PARAMS_REP_CITYID ] );
		}

		if ( isset( $aParams[ self::SD_PARAMS_REP_COMP_CITYID ] ) ) {
			$this->repeatFromCompetitorsCityId = ( $aParams[ self::SD_PARAMS_REP_COMP_CITYID ] );
		}

		if ( isset( $aParams[ self::SD_PARAMS_REP_COMP_HUBID ] ) ) {
			$this->repeatFromCompetitorsHubId = ( $aParams[ self::SD_PARAMS_REP_COMP_HUBID ] );
		}

		if ( isset( $aParams[ self::SD_PARAMS_REP_TOPX ] ) ) {
			$this->repeatFromCompetitorsTopX = ( $aParams[ self::SD_PARAMS_REP_TOPX ] );
		}

		if ( isset( $aParams[ self::SD_PARAMS_REP_SOURCE_TYPE ] ) ) {
			$this->sourceType = ( $aParams[ self::SD_PARAMS_REP_SOURCE_TYPE ] );
		}
	}

	/*
	 * Main getter that returns all parameters ( common and source specyfic ).
	 *
	 * @param boolean $offForSourceCache.
	 * If set tu true will prevent returning general params. Used in cache key building.
	 *
	 * @return array
	 */

	protected function getParamsArray( $offForSourceCache = false ) {

		$aGeneral = ( $offForSourceCache ) ? array() : $this->getGeneralParamsArray();
		$aLocal = $this->getLocalParamsArray();
		$array = array_merge( $aGeneral, $aLocal );
		return $array;
	}

	/*
	 * checkes if subclass exists.
	 *
	 * @param string $dbKey.
	 * source type stored in database and array keys.
	 *
	 * @return string - className
	 */

	public static function sourceClassFromDBKey( $dbKey ) {

		$tmpClassName = 'SponsorshipDashboardSource'.$dbKey;
		if( class_exists( $tmpClassName ) ) {
			return $tmpClassName;
		}

		// 2DO add exception
		return 'SponsorshipDashboardSourceGapi';
	}

	/*
	 * returns source builder form data.
	 * @return string - html
	 */

	public function getFormHTML() {

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$aVars = array();
		$aVars['hubs'] = $this->getGeneralHubList();
		$aVars['data'] = $this->getParamsArray();
		$oTmpl->set_vars( $aVars );

		return $oTmpl->render( $this->getMenuTemplateLink() );
	}

	/*
	 * returns list of the hubs - used to build getFormHTML
	 *
	 * @return array
	 */

	protected function getGeneralHubList() {

		Wikia::log( __METHOD__, 'Depreciated' );
	}

	/*
	 * fills object with data from database.
	 *
	 * @return void
	 */

	public function loadSource() {


		if ( !empty( $this->sourceId ) ) {

			$dbr = wfGetDB( DB_SLAVE, array(), SponsorshipDashboardService::getDatabase() );
			if ( !is_null( $dbr ) ) {
				$res = $dbr->select(
					'specials.wmetrics_source_params',
					array( 'wmsop_value as value', 'wmsop_type as type' ),
					array( 'wmsop_source_id = '. $this->sourceId ),
					__METHOD__,
					array()
				);

				$aParams = array();
				while ( $row = $res->fetchObject( $res ) ) {
					$aParams[ $row->type] = $row->value;
				}
				$this->fillFromArray( $aParams );
			}
		}
	}

	/*
	 * Cache function
	 */

	protected function getKey( $prefix, $cityId = false ) {

		if ( empty( $cityId ) ) {
			$cityId = WF::build( 'App' )->getGlobal( 'wgCityId' );
		}
		return wfSharedMemcKey( 'WikiaMetrics2', $prefix, $cityId );
	}

	protected function loadDataFromCache() {
		$wgMemc = $this->App->getGlobal('wgMemc');
		$memcData = $wgMemc->get( $this->getCacheKey() );

		if ( !empty( $memcData ) && isset( $memcData['dataAll'] ) && isset( $memcData['dataTitles'] ) ) {
			$this->dataAll = $memcData['dataAll'];
			$this->dataTitles = $memcData['dataTitles'];
			$this->actualDate = isset( $memcData['cacheDate'] ) ? $memcData['cacheDate'] : date('Y-m-d G:i:s');

			return true;
		}

		return false;
	}

	protected function saveDataToCache() {

		if ( !empty( $this->dataAll ) && !empty( $this->dataTitles ) ) {
			$wgMemc = $this->App->getGlobal('wgMemc');
			$wgMemc->set(
				$this->getCacheKey(),
				array( 'dataAll' => $this->dataAll , 'dataTitles' => $this->dataTitles, 'cacheDate' => date('Y-m-d G:i:s') ),
				( strtotime('tomorrow') - time() )
			);
		}
	}

	abstract public function getCacheKey();

}
