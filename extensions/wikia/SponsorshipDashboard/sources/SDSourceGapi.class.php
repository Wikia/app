<?php

/**
 * SponsorshipDashboard
 * @author Jakub "Szeryf" Kurcek
 *
 * Googla API source.
 */

class SponsorshipDashboardSourceGapi extends SponsorshipDashboardSource {

	const SD_FROM_INDEX = 1;
	const SD_MAX_RESULTS = 365;
	const SD_DATE_CELL = 'date';

	const SD_GAPI_RETRIES = 50;
	const SD_GAPI_RESULT_EMPTY = '';
	const SD_MC_KEY_PREFIX_GAPI = 'Gapi';

	const SD_SOURCE_TYPE = 'Gapi';

	const SD_SOURCE_URL = 'URL';
	const SD_PARAMS_REP_URL = 'repURL';
	const SD_PARAMS_REP_FORCE_ACCOUNT = 'forceUser';
	const SD_PARAMS_REP_SERIE_NAME = 'serieName';

	static $SD_GAPI_ALLOWED_METRICS = array(
		'visitors',
		'newVisits',
		'percentNewVisits',
		'visits',
		'timeOnSite',
		'avgTimeOnSite',
		'organicSearches',
		'entrances',
		'entranceRate',
		'visitBounceRate',
		'pageviews',
		'pageviewsPerVisit',
		'uniquePageviews',
		'avgTimeOnPage',
		'exits',
		'exitRate'
	);

	static $SD_GAPI_ALLOWED_DIMENSIONS = array(
		'keyword',
		'medium',
		'continent',
		'country',
		'browser',
	);

	public $GAPImetrics = array();
	public $GAPImetricNames = array();
	public $extraDimension = '';
	public $inCaseOfEmptyResult = self::SD_GAPI_RESULT_EMPTY;
	public $maxAddDimensions = 10;

	protected $frequency;
	protected $url = '';
	protected $account = 0;
	protected $serieName = '';
	protected $startDate = false;
	protected $endDate = false;

	// ============================

	public function __construct( $id = 0 ) {

		parent::__construct( $id = 0 );

		$this->frequency = SponsorshipDashboardDateProvider::getProvider();
		$this->recalculateDateVariables();
		$this->fromYear = 2010;
		$this->startDate = $this->frequency->getGapiStartDate( $this->lastDateUnits );
		$this->account = $this->getAccount();
	}

	/*
	 * Returns calss DB identifier.
	 *
	 * @return string
	 */

	public function getSourceKey() {
		return 'Gapi';
	}

	/*
	 * Returns source memcache key. Key is built from varaibles specyfic for current serie.
	 *
	 * @return string
	 */

	public function getCacheKey() {

		$aKey = $this->getParamsArray( true );
		$sKey = ( is_array( $aKey ) ) ? md5( implode( ':', $aKey ) ) : '';
		return
			self::SD_MC_KEY_PREFIX.':'
			. self::SD_MC_KEY_PREFIX_GAPI
			. ':'
			. md5( $this->getGAFilters()
			. $this->getName()
			. $this->getAccount())
			. $sKey;
	}

	/*
	 *  Setters / Getters / Validators
	 */

	public function setFrequency( $frequency ) {

		$this->frequency =  SponsorshipDashboardDateProvider::getProvider( $frequency );
	}

	public function setMetrics ( $metrics ) {

		$finalMetrics = array();
		if ( is_array( $metrics ) ) {
			$metric = array_unique( $metrics );
			foreach ( $metrics as $metric ) {
				if ( in_array( trim( $metric ), self::$SD_GAPI_ALLOWED_METRICS ) ) {
					$finalMetrics[] = trim( $metric );
				}
			}
		}
		$this->GAPImetrics = $finalMetrics;
	}

	public function setMetricName ( $metric, $metricName ) {

		// we don't want to store default values in DB
		if ( in_array( $metric, self::$SD_GAPI_ALLOWED_METRICS ) && $metric != $metricName ){
			$this->GAPImetricNames[ $metric ] = $metricName;
		}
	}

	public function setOnEmpty ( $string ) {

		if ( !empty( $string ) ) {
			$this->inCaseOfEmptyResult = $string;
		}
	}

	public function setExtraDimension ( $dimension ) {

		if ( in_array( trim( $dimension ), self::$SD_GAPI_ALLOWED_DIMENSIONS ) ) {
			$this->extraDimension = trim( $dimension );
		}
	}

	protected function recalculateDateVariables() {

		$this->endDate = $this->frequency->getGapiEndDate();
		$this->startDate =  $this->frequency->getGapiStartDate( $this->lastDateUnits );
	}

	public function validFrequency( $frequency ) {

		return in_array(
			$frequency,
			array(
			    SponsorshipDashboardDateProvider::SD_FREQUENCY_MONTH,
			    SponsorshipDashboardDateProvider::SD_FREQUENCY_DAY
			)
		);
	}

	public function getAccount() {

		if( empty( $this->account ) ) {
			return F::app()->getGlobal('wgWikiaGAAccount');
		} else {
			return $this->account;
		}
	}

	public function getName() {

		if ( $this->sourceType == SponsorshipDashboardSource::SD_SOURCE_GLOBAL ) {
			return wfMsg( 'sponsorship-dashboard-source-global').': ';
		}
		if( empty( $this->serieName ) ) {
			return $this->getCityPrefix();
		} else {
			return $this->serieName.': ';
		}
	}

	/*
	 * Fils object from the database.
	 *
	 * @return void
	 */

	protected function loadData() {

		if ( !$this->dataLoaded ) {
			if ( !$this->loadDataFromCache() ) {

				global $wgWikiaGALogin, $wgWikiaGAPassword, $wgHTTPProxy, $wgDevEnvironment;

				if( count( $this->GAPImetrics ) > 0 ) {
					$results = $this->getGapiResults();
					$all = array();
					$titles = array();
					reset( $results );
					// unset ( $results[ key( $results ) ] );

					$this->calculateResults( $results );
					$this->saveDataToCache();
				}
			}
			$this->dataLoaded = true;
		}
	}

	/*
	 * fetches data from Google API.
	 *
	 * @param string $dbKey.
	 * source type stored in database and array keys.
	 *
	 * @return string - className
	 */

	protected function getGapiResults() {

		global $wgWikiaGAAccount, $wgWikiaGALogin, $wgWikiaGAPassword, $wgHTTPProxy;

		$retries = self::SD_GAPI_RETRIES;
		$results = array();

		$dimensions = $this->frequency->getGapiDateDimensionsTable();
		$sortBy = $this->frequency->getGapiSortingDate();

		if ( !empty( $this->extraDimension ) ) {
			$dimensions[] = $this->extraDimension;
			$sortBy[] = $this->extraDimension;
		}

		$ga = new gapi( $wgWikiaGALogin, $wgWikiaGAPassword, null, 'curl', $wgHTTPProxy );

		while ( ( $retries > 0 ) && empty( $results ) ) {
			try {
				$ga->requestReportData(
					$this->getAccount(),
					$dimensions,
					$this->GAPImetrics,
					$sortBy,
					$this->getGAFilters(),
					$this->startDate,
					$this->endDate,
					1,
					10000
				);
				$results = $ga->getResults();
				break;

			} catch ( Exception $e ) {
				$retries--;
				sleep( 1 );
				Wikia::log( __METHOD__, 'jku', $e->getMessage() );
			}
		}

		return $results;
	}


	/*
	 * Generates series and values parameters basis.
	 *
	 * @param obj $results.
	 *
	 * @return vaoid
	 */

	protected function calculateResults( $results ) {

		$DatabasePrefix = $this->getCityPrefix();

		if ( !empty( $this->extraDimension ) ) {
			$sDimensionName = 'get'.ucfirst( $this->extraDimension );

			// 2DO: need to find a better way to do this
			// 2DO: work with gapi limitations.

			$importantKeywords = array();
			$importantKeywordsMap = array();
			foreach( $results as $res ) {
				$Keyword = $res->$sDimensionName();
				if ( !$this->isResultEmpty( $Keyword ) ){
					$md5Keyword = md5( $Keyword );
					$testMetric = array_keys( $this->GAPImetrics );
					$sName = 'get'.ucfirst( $this->GAPImetrics[$testMetric[0]] );
					$importantKeywords[ $md5Keyword ] = $Keyword;

					if ( isset( $importantKeywordsMap[ $md5Keyword ] ) ){
						$importantKeywordsMap[ $md5Keyword ] += $res->$sName();
					} else {
						$importantKeywordsMap[ $md5Keyword ] = $res->$sName();
					}
				}
			}

			arsort( $importantKeywordsMap );

			$importantKeywordsMap = array_slice( $importantKeywordsMap, 0, $this->maxAddDimensions );
			foreach( $importantKeywordsMap as $key => $val ){
				$finalKeyword[] = $importantKeywords[$key];
			}

			foreach( $results as $res ) {

				$dimension = $res->$sDimensionName();

				if ( in_array( $dimension, $finalKeyword ) ){

					if ( $this->isResultEmpty( $dimension ) ) {
						if ( $this->inCaseOfEmptyResult == self::SD_GAPI_RESULT_EMPTY ) {
							continue;
						} else {
							$dimension =  $this->inCaseOfEmptyResult;
						}
					}
					$sDate = $this->frequency->getGapiDateFromResult( $res );
					$this->dataAll[ $sDate ][ 'date' ] = $sDate;
					foreach ( $this->GAPImetrics as $metric ) {
						$this->dataAll[ $sDate ][ 'a'.md5( $dimension.$metric.$this->getGAFilters().$this->getAccount().$this->getName() ) ] = $this->getMetricValue( $res, $metric );
						$this->dataTitles[ 'a'.md5( $dimension.$metric.$this->getGAFilters().$this->getAccount().$this->getName() ) ] = $this->getName().$this->getMetricName( $metric ).': '.$dimension;
					}
				}
			}

		} else {
			foreach( $results as $res ) {
				$sDate = $this->frequency->getGapiDateFromResult( $res );
				$this->dataAll[ $sDate ][ self::SD_DATE_CELL ] = $sDate;
				foreach ( $this->GAPImetrics as $metric ) {
					$this->dataAll[ $sDate ][ 'a'.md5( $metric.$this->getGAFilters().$this->getAccount().$this->getName() ) ] = $this->getMetricValue( $res, $metric );
				}
			}
			foreach ( $this->GAPImetrics as $metric ) {
				$this->dataTitles[ 'a'.md5( $metric.$this->getGAFilters().$this->getAccount().$this->getName() ) ] = $this->getName().$this->getMetricName( $metric );
			}
		}
	}

	public function getMetricValue( $res, $metric ){

		// add sampling
		$aSampling = F::app()->sendRequest(
			'GoogleAnalyticsSampling',
			'getSamplingRate',
			array( 'date' => $this->frequency->getGapiSamplingDateFromResult( $res ) )
		)->getData();
		$iSampling = 100/$aSampling[ GoogleAnalyticsSamplingController::SAMPLING_RATE ];
		$sName = 'get'.ucfirst( $metric );

		// hack for displaying hours insteed of seconds
		if ( in_array( $metric, array( 'timeOnSite', 'avgTimeOnSite', 'avgTimeOnPage' ) ) ){
			return floor( $res->$sName() / 360 );
		}
		$iValue = $iSampling * $res->$sName();
		return $iValue;
	}

	public function getMetricName( $metric ){
		if ( isset( $this->GAPImetricNames[ $metric ] ) ){
			return $this->GAPImetricNames[ $metric ];
		}
		return wfMsg( self::SD_MSG_PREFIX.$metric );
	}

	/*
	 * Generates Google API query basing on source params values.
	 *
	 * @return string - url
	 */

	protected function getGAFilters() {

		if ( $this->sourceType == SponsorshipDashboardSource::SD_SOURCE_GLOBAL ){
			return '';
		}

		if ( !empty( $this->url ) ) {
			return $this->url;
		}
		$filter = 'hostname=~^'.$this->getGAUrlFromCityId();
		return $filter;
	}

	/*
	 * Generates Google API query url for specyfic cityId.
	 *
	 * @return string - url
	 */

	protected function getGAUrlFromCityId() {

		$url = WikiFactory::getWikiByID( $this->getCityId() )->city_url;
		$hostname = str_replace( 'http://', '', $url );
		$hostname = str_replace( '/', '', $hostname );

		return $hostname;
	}

	protected function isResultEmpty( $string ) {

		return (
			( strpos( $string, '(') === 0 ) &&
			( strpos( $string, ')') == ( strlen( $string ) -1 ) )
			);
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
		$aData[ SponsorshipDashboardSource::SD_PARAMS_FREQUENCY ] = $this->frequency->getType();
		$aData[ self::SD_PARAMS_GAPI_EXTRADIM ] = $this->extraDimension;
		$aData[ self::SD_PARAMS_GAPI_EMPTYRES ] = $this->inCaseOfEmptyResult;
		$aData[ self::SD_PARAMS_GAPI_MAX_ADDITIONAL_DIMENSIONS ] = $this->maxAddDimensions;
		$aData[ self::SD_PARAMS_GAPI_METRICS ] = implode( ',', $this->GAPImetrics );
		$aData[ self::SD_PARAMS_REP_URL ] = $this->url;
		$aData[ self::SD_PARAMS_REP_FORCE_ACCOUNT ] = $this->account;
		$aData[ self::SD_PARAMS_REP_SERIE_NAME ] = $this->serieName;
		$aData[ self::SD_PARAMS_GAPI_METRICS_NAMES ] = serialize( $this->GAPImetricNames );

		return $aData;
	}

	public function getMenuTemplateLink() {

		return '../../templates/editor/addNewGapi';
	}

	const SD_PARAMS_GAPI_METRICS = 'metrics';
	const SD_PARAMS_GAPI_METRICS_NAMES = 'metricsNames';
	const SD_PARAMS_GAPI_EMPTYRES = 'inCaseOfEmptyResult';
	const SD_PARAMS_GAPI_EXTRADIM = 'extraDimension';
	const SD_PARAMS_GAPI_MAX_ADDITIONAL_DIMENSIONS = 'maxAddDimensions';

	/*
	 * Fills object from array. Used when creating object from form results.
	 *
	 * @return string - url
	 */

	public function fillFromArray( $aParams ) {

		$aMetrics = array();


		// Metrics from form
		foreach( self::$SD_GAPI_ALLOWED_METRICS as $metric ) {
			if ( isset( $aParams[ 'sourceMetric-'.$metric ] ) && $aParams[ 'sourceMetric-'.$metric ] == 'on' ) {
				$aMetrics[] = $metric;
			}
		}

		if ( !empty( $aMetrics ) ) {
			$this->setMetrics( $aMetrics );
		}

		// Metrics from DB
		if ( isset( $aParams[ self::SD_PARAMS_GAPI_METRICS ] ) ) {
			$this->setMetrics(
				explode( ',', $aParams[ self::SD_PARAMS_GAPI_METRICS ] )
			);
		}

		// Metric's names from form
		foreach( self::$SD_GAPI_ALLOWED_METRICS as $metric ) {
			if ( isset( $aParams[ 'sourceMetricName-'.$metric ] ) && !empty( $aParams[ 'sourceMetricName-'.$metric ] ) ) {
				$this->setMetricName( $metric, $aParams[ 'sourceMetricName-'.$metric ] );
			}
		}

		// Metric's names from DB
		if ( isset( $aParams[ self::SD_PARAMS_GAPI_METRICS_NAMES ] ) ) {
			$tmpMetricNames = unserialize( $aParams[ self::SD_PARAMS_GAPI_METRICS_NAMES ], [ 'allowed_classes' => false ] );
			if ( is_array( $tmpMetricNames ) ){
				foreach( $tmpMetricNames as $key => $val){
					$this->setMetricName( $key, $val );
				}
			}

		}

		if ( isset( $aParams[ self::SD_PARAMS_GAPI_EMPTYRES ] ) ) {
			$this->setOnEmpty( $aParams[ self::SD_PARAMS_GAPI_EMPTYRES ] );
		}

		if ( isset( $aParams[ self::SD_PARAMS_GAPI_MAX_ADDITIONAL_DIMENSIONS ] ) ) {
			$this->maxAddDimensions = (int) $aParams[ self::SD_PARAMS_GAPI_MAX_ADDITIONAL_DIMENSIONS ];
		}

		if ( isset( $aParams[ self::SD_PARAMS_GAPI_EXTRADIM ] ) ) {
			$this->setExtraDimension( $aParams[ self::SD_PARAMS_GAPI_EXTRADIM ] );
		}

		if ( isset( $aParams[ SponsorshipDashboardSource::SD_PARAMS_FREQUENCY ] ) ) {
			$this->setFrequency( $aParams[ SponsorshipDashboardSource::SD_PARAMS_FREQUENCY ] );
		}

		if ( isset( $aParams[ SponsorshipDashboardSourceGapi::SD_PARAMS_REP_URL ] ) ) {
			$this->url = $aParams[ SponsorshipDashboardSourceGapi::SD_PARAMS_REP_URL ];
		}

		if ( isset( $aParams[ SponsorshipDashboardSourceGapi::SD_PARAMS_REP_FORCE_ACCOUNT ] ) ) {
			$this->account = $aParams[ SponsorshipDashboardSourceGapi::SD_PARAMS_REP_FORCE_ACCOUNT ];
		}

		if ( isset( $aParams[ SponsorshipDashboardSourceGapi::SD_PARAMS_REP_SERIE_NAME ] ) ) {
			$this->serieName = $aParams[ SponsorshipDashboardSourceGapi::SD_PARAMS_REP_SERIE_NAME ];
		}

		$this->setGeneralParamsFromArray( $aParams );

		return true;
	}
}
