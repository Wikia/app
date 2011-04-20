<?php
/**
 * SponsorshipDashboard
 * @author Jakub "Szeryf" Kurcek
 *
 * WikiaStats source.
 */

class SponsorshipDashboardSourceStats extends SponsorshipDashboardSource {

	const SD_START_MONTH = '01';
	const SD_START_YEAR = '2008';
	const SD_DATE_CELL = 'date';

	const SD_MSG_PREFIX_NAMESPACE = 'sponsorship-dashboard-serie-namespace-';
	const SD_SOURCE_TYPE = 'Stats';

	static $allowedSeries = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K' );
	
	protected $startMonth = false;
	protected $startYear = false;
	protected $endMonth = false;
	protected $endYear = false;
	
	protected $namespaces = array();
	public $series = array();
	public $seriesNames = array();


	var $mStats;

	// ============================

	public function __construct() {

		$this->iNumberOfXGuideLines = 7;
		$this->App = WF::build('App');
		$this->cityId = $this->App->getGlobal('wgCityId');
	}

	/*
	 * Returns calss DB identifier.
	 *
	 * @return string
	 */

	public function getSourceKey() {
		return 'Stats';
	}

	/*
	 * Returns source memcache key. Key is built from varaibles specyfic for current serie.
	 *
	 * @return string
	 */

	public function getCacheKey() {

		$aKey = array();

		$aKey[] = $this->cityId;
		$aKey[] = $this->cityIdForced;
		$aKey[] = $this->lastDateUnits;

		$aKey[] = implode( ',', $this->series );
		$aKey[] = serialize( $this->seriesNames );
		$aKey[] = $this->startMonth;
		$aKey[] = $this->startYear;
		$aKey[] = $this->endMonth;
		$aKey[] = $this->endYear;
		$aKey[] = implode( ',', $this->namespaces );
		return self::SD_MC_KEY_PREFIX.':'.self::SD_SOURCE_TYPE.':'.md5(implode( ':', $aKey ));
	}

	/*
	 *  Setters / Getters / Validators
	 */

	public function setNamespaces( $aNamespaces = array() ) {
		
		$this->namespaces = array();
		if (is_array( $aNamespaces )) {
			foreach( $aNamespaces as $namespace) {
				if ( MWNamespace::exists( $namespace ) ) {
					$this->namespaces[] = $namespace;
				}
			}
		}
	}

	public function setSeries( $aSeries = array() ) {

		$this->namespaces = array();
		if ( is_array( $aSeries )) {
			foreach( $aSeries as $serie) {
				if ( in_array( $serie, self::$allowedSeries ) ) {
					$this->series[] = $serie;
				}
			}
		}
	}

	public function setSeriesName( $serie, $serieName ) {

		// we don't want to store default values in DB
		if ( in_array( $serie, self::$allowedSeries ) && wfMsg( 'sponsorship-dashboard-serie-'.$serie ) != $serieName ) {
			$this->seriesNames[ $serie ] = $serieName;
		}
	}

	protected function recalculateDateVariables() {

		$this->endMonth = date( "m", mktime( 0, 0, 0, date( "m" )-1, 1, date( "Y" )));
		$this->endYear = date( "Y", mktime( 0, 0, 0, date( "m" )-1, 1, date( "Y" )));
		$this->startMonth = ( !empty($this->lastDateUnits) ) ? date( "m", mktime( 0, 0, 0, ( date( "m" )-$this->lastDateUnits), 0 , date( "Y" ))) : self::SD_START_MONTH;
		$this->startYear = ( !empty($this->lastDateUnits) ) ? date( "Y", mktime( 0, 0, 0, ( date( "m" )-$this->lastDateUnits), 0 , date( "Y" ))) : self::SD_START_YEAR;
	}

	// ============================
	
	/*
	 * Fils object from the database.
	 *
	 * @return void
	 */

	protected function loadData() {

		if ( !$this->dataLoaded ) {

			$this->getResults();
			$this->dataLoaded = true;
		}
	}

	protected function getResults() {

		$this->recalculateDateVariables();

		if ( !$this->loadDataFromCache() ) {

			$this->mStats = WikiStats::newFromId( $this->getCityId() );
			$this->mStats->setStatsDate(
				array(
					'fromMonth'	=> $this->startMonth,
					'fromYear' 	=> $this->startYear,
					'toMonth'	=> $this->endMonth,
					'toYear'	=> $this->endYear
				)
			);

			$this->mStats->setHub("");
			$this->mStats->setLang("");

			// returns data from the point it begun
			$aData = $this->mStats->loadStatsFromDB();

			foreach( $aData as $collumns ) {
				$date = date("Y-m", strtotime( "1.".substr( $collumns['date'], 4, 2 ).".".substr( $collumns['date'], 0, 4 ) ) );

				$this->dataAll[ $date ][ self::SD_DATE_CELL ] = $date;
				foreach ( $this->series as $serie ) {
					$this->dataAll[ $date ][ 'a'.md5( $this->getCityId().$serie ) ] = $collumns[ $serie ];
				}
			}
			
			foreach ( $this->series as $serie ) {
				$this->dataTitles[ 'a'.md5( $this->getCityId().$serie ) ] = $this->getCityPrefix().$this->getSerieName( $serie );
			}

			foreach( $this->namespaces as $iNamespace ) {
				$this->pushArticleNumbersFromNamespace( $iNamespace );		
			}

			$i = 0;
			$this->saveDataToCache();
		}
	}

	public function getSerieName( $serie ) {

		if ( isset( $this->seriesNames[ $serie ] ) ) {
			return $this->seriesNames[ $serie ];
		}
		return wfMsg( self::SD_MSG_PREFIX.$serie );
	}

	protected function pushArticleNumbersFromNamespace( $iNamespace ) {

		$this->mStats->mPageNS = array( $iNamespace );
		$this->mStats->mPageNSList = array( $iNamespace );

		$aDataNS = $this->mStats->namespaceStatsFromDB();

		$sKey = 'a'.md5( $this->getCityId().'fromNamespace'.$iNamespace );

		if( !empty( $aDataNS )) {
			foreach( $aDataNS as $key => $val) {
				$date = date("Y-m", strtotime( "1.".substr( $key, 4, 2 ).".".substr( $key, 0, 4 ) ) );

				if ( !isset( $this->dataAll[ $date ] ) ) $this->dataAll[ $date ] = array();
				$this->dataAll[ $date ][ $sKey ] =
					$val[ $iNamespace ][ 'A' ];
				$this->dataAll[ $date ][ self::SD_DATE_CELL ] = $date;
			}

			$this->dataTitles[ $sKey ] = $this->getCityPrefix().wfMsg( self::SD_MSG_PREFIX_NAMESPACE.MWNamespace::getCanonicalName( $iNamespace ) );
		}
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
		$aData[ self::SD_PARAMS_STATS_NAMESPACES ] = implode( ',', $this->namespaces );
		$aData[ self::SD_PARAMS_STATS_SERIES ] = implode( ',', $this->series );
		$aData[ self::SD_PARAMS_STATS_SERIES_NAMES ] = serialize( $this->seriesNames );
		return $aData;
	}

	public function getMenuTemplateLink() {

		return '../../templates/editor/addNewStats';
	}

	const SD_PARAMS_STATS_NAMESPACES = 'namespaces';
	const SD_PARAMS_STATS_SERIES = 'series';
	const SD_PARAMS_STATS_SERIES_NAMES = 'seriesNames';
	
	/*
	 * Fills object from array. Used when creating object from form results.
	 *
	 * @return string - url
	 */

	public function fillFromArray( $aParams ) {

		$sources = array();
		foreach( self::$allowedSeries as $aSeries ) {
			if ( isset( $aParams[ self::SD_PARAMS_STATS_SERIES.$aSeries ] ) && !empty( $aParams[ self::SD_PARAMS_STATS_SERIES.$aSeries ] ) ) {
				$sources[] = $aSeries;
			}
		}

		if( !empty( $sources ) ) {
			$this->setSeries( $sources );
		} else {
			if ( isset( $aParams[ self::SD_PARAMS_STATS_SERIES ] ) ) {
				$this->setSeries( explode( ',', $aParams[ self::SD_PARAMS_STATS_SERIES ] ) );
			}
		}

		// Metric's names from form
		foreach( self::$allowedSeries as $serie ) {
			if ( isset( $aParams[ 'sourceSerieName-'.$serie ] ) && !empty( $aParams[ 'sourceSerieName-'.$serie ] ) ) {
				$this->setSeriesName( $serie, $aParams[ 'sourceSerieName-'.$serie ] );
			}
		}

		// Metric's names from DB
		if ( isset( $aParams[ self::SD_PARAMS_STATS_SERIES_NAMES] ) ) {

			try {
				$tmpSerieNames = @unserialize( $aParams[ self::SD_PARAMS_STATS_SERIES_NAMES ] );
			} catch ( MyException $e) {
				$tmpSerieNames = false;
			}

			if ( is_array( $tmpSerieNames ) ) {
				foreach( $tmpSerieNames as $key => $val) {
					$this->setSeriesName( $key, $val );
				}
			}

		}

		if ( isset( $aParams[ self::SD_PARAMS_STATS_NAMESPACES ] ) && !empty( $aParams[ self::SD_PARAMS_STATS_NAMESPACES ] ) ) {
			$aNamespaces = explode( ',', $aParams[ self::SD_PARAMS_STATS_NAMESPACES ] );
			$this->setNamespaces( $aNamespaces );
		}
		
		$this->setGeneralParamsFromArray( $aParams );
	}

	public function validFrequency( $frequency ) {

		return in_array(
			$frequency,
			array(
			    SponsorshipDashboardDateProvider::SD_FREQUENCY_MONTH
			)
		);
	}
}
