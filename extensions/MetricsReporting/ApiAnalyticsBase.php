<?php

abstract class ApiAnalyticsBase extends ApiBase {

	/**
	 * @var DatabaseBase
	 */
	protected $mDb;

	protected $isCurrentlyNormalised = false;

	public function __construct( ApiBase $query, $moduleName ) {
		parent::__construct( $query->getMain(), $moduleName );
	}

	/**
	 * Get the Query database connection (read-only)
	 * @return DatabaseBase
	 */
	protected function getDB() {
		if ( is_null( $this->mDb ) ) {
			global $wgMetricsDBserver, $wgMetricsDBname, $wgMetricsDBuser,
				$wgMetricsDBpassword, $wgMetricsDBtype, $wgMetricsDBprefix,
				$wgDebugDumpSql;
			$this->mDb = DatabaseBase::factory( $wgMetricsDBtype,
				array(
					'host' => $wgMetricsDBserver,
					'user' => $wgMetricsDBuser,
					'password' => $wgMetricsDBpassword,
					'dbname' => $wgMetricsDBname,
					'tablePrefix' => $wgMetricsDBprefix,
					'flags' => ( $wgDebugDumpSql ? DBO_DEBUG : 0 ) | DBO_DEFAULT,
				)
			);
			//$this->mDb->query( "SET names utf8" );
		}
		return $this->mDb;
	}

	public function execute() {
		$params = $this->extractRequestParams();

		if ( $this->canBeNormalised() && $params['normalized'] ) {
			$this->normaliseQueryParameters( true );
		}
		$query = $this->getQueryInfo();
		$query['fields'] = $this->getQueryFields();

		// TODO: Do we need to do the dates as Like? (bleugh)
		// Else, strtotime( '(First|Last) day of Month YYYY' )
		$db = $this->getDB();
		if ( $params['startmonth'] && !$params['endmonth'] ) {
			$query['conds']['date'] = $params['startmonth'];
		} else {
			// Note: date must be YYYY-MM-DD, using YYYY-MM may make nasty queries
			//add 1 month to end of date because of the way data is stored
			$endMonth = date( "Y-m-d", strtotime( $params['endmonth'] . " +1 month" ) );

			$query['conds'][] = "date >= " . $db->addQuotes( $params['startmonth'] )
							. " AND date <= " . $db->addQuotes( $endMonth ) ;
		}

		// TODO: Data formatting
		/*foreach( $params['data'] as $data ) {
			switch ( $data ) {
				case 'timeseries':
					break;
				case 'timeseriesindexed':
					break;
				case 'percentagegrowthlastmonth':
					break;
				case 'percentagegrowthlasyyear':
					break;
				case 'percentagegrowthfullperiod':
					break;
			}
		}*/
		//note: this means if you specify a report language that is not
		//fully supported, you won't get a full data set back
		if( $this->takesReportLanguage() ){
			$query['conds']['report_language'] = $params['reportlanguage'];
		}

		$titleFields = array();

		foreach( $this->getAllowedFilters() as $filter ) {
			if ( !isset( $params[$filter] ) ) {
				continue;
			}
			if ( $params[$filter][0] === '*' ) {
				// For */"all", don't do any filtering
				continue;
			}

			$parsedFilter = $this->getAllUniqueParams( $params[$filter] );
			switch ( $filter ) {
				case 'selectregions':
					// a, b, c
					$query['conds']['comscore_regions.region_code'] = $parsedFilter;
					$titleFields[] = 'region_code';
					$titleFields[] = 'region_name';
					break;
				case 'selectcountries':
					// b, c, d
					// TODO: Cater for "top:20" etc
					$query['conds']['country_code'] = $parsedFilter;
					$titleFields[] = 'country_code';
					break;
				case 'selectwebproperties':
					/*if ( $params['authcode'] != 'some string' ) {
						$this->dieUsage( 'Wrong code', 'badcode' );
					}*/
					// c, d
					// TODO: Cater for "top:20" etc
					$query['conds']['web_property'] = $parsedFilter;
					$titleFields[] = '';
					break;
				case 'selectprojects':
					// c
					$query['conds']['project_code'] = $parsedFilter;
					$titleFields[] = 'project_code';
					break;
				case 'selectwikis':
					// c
					// TODO: What's the format of the query need to be?
					// ( lang = ltarget AND project = ptarget ) OR ( lang =ltarget2 AND project = ptarget2 )
					$query['conds'][''] = $parsedFilter;
					$titleFields[] = '';
					break;
				case 'selecteditors':
					// b, c
					// TODO: Need where column
					$query['conds'][''] = $parsedFilter;
					$titleFields[] = '';
					break;
				case 'selectedits':
					// b, c
					// TODO: Need where column
					$query['conds'][''] = $parsedFilter;
					$titleFields[] = '';
					break;
				case 'selectplatform':
					// b, c
					// TODO: Need where column
					$query['conds'][''] = $parsedFilter;
					$titleFields[] = '';
					break;
			}
		}

		$this->profileDBIn();
		$res = $db->select( $query['table'], $query['fields'], $query['conds'], __METHOD__, $query['options'], $query['join_conds'] );
		$this->profileDBOut();

		$result = $this->getResult();

		$fields = array_map( array( $this, 'getColumnName' ), $query['fields'] );

		$storageKey = count( $titleFields ) ? $titleFields[0] : null;
		$things = array();
		// Build result set
		foreach( $res as $row ) {
			if( isset( $storageKey ) && !isset( $things[$row->$storageKey] ) ) { // find dynamic value for each query type
				$things[$row->$storageKey] = array();
				foreach( $titleFields as $field ) {
					$things[$row->$storageKey][$field] = $row->$field;
				}
			}

			// Dump rest of data to output
			$item = array();
			foreach( array_diff( $fields, $titleFields ) as $field ) {
				$item[$field] = $row->$field;
			}

			if( isset( $storageKey ) ){
				$things[$row->$storageKey]['data'][] = $item;

				$result->setIndexedTagName( $things[$row->$storageKey]['data'], 'd' );
			} else {
				$result->addValue( array( $this->getModuleName() ), null, $item );
			}
		}

		// Add data to the output
		foreach( $things as $thing ) {
			$result->addValue( array( $this->getModuleName() ), null, $thing );
		}
		$result->setIndexedTagName_internal( array( $this->getModuleName() ), 'set' );

	}

	// TODO: Deal with foo AS bar, and return bar for nicer aliasing of stuff
	/**
	 * Looks to see if the column is fully qualified (table.column)
	 * If is, return only the column name
	 *
	 * @param $col Column name
	 * @return string
	 */
	private function getColumnName( $col ) {
		$pos = strpos( $col, '.' );

		if ( !$pos ) {
			return $col;
		}
		return substr( $col, $pos + 1 );
	}

	/**
	 * array( 'a', 'b', 'c', 'a', 'a,c' ) => array( 'a', 'b', 'c' )
	 *
	 * @param $array
	 * @return array
	 */
	private function getAllUniqueParams( $array ) {
		$ret = array();
		foreach( $array as $a ) {
			$pos = strpos( $a, ',' );
			if ( !$pos ) {
				$ret[] = $a;
				continue;
			}
			$ret = array_merge( $ret, explode( ',', $a ) );
		}
		return array_unique( $ret );
	}

	protected abstract function getQueryInfo();

	protected abstract function getQueryFields();

	/**
	 * @return bool
	 */
	protected function canBeNormalised() {
		return false;
	}

	/**
	 * @param $params array
	 * @return  array
	 */
	public function normaliseQueryParameters( $normalise = false ) {
		$this->isCurrentlyNormalised = $normalise;
	}

	/**
	 * @return array
	 */
	public function getAllowedFilters() {
		return array();
	}

	/**
	 * @return bool
	 */
	protected function takesReportLanguage(){
		return false;
	}

	public function getAllowedParams() {
		$params = array(
			'startmonth' => array(
				ApiBase::PARAM_TYPE => 'string',
				ApiBase::PARAM_REQUIRED => true,
			),
			'endmonth' => array(
				ApiBase::PARAM_TYPE => 'string',
			),
			'data' => array(
				ApiBase::PARAM_DFLT => 'timeseries',
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_REQUIRED => true,
				ApiBase::PARAM_TYPE => array(
					'timeseries',
					'timeseriesindexed',
					'percentagegrowthlastmonth',
					'percentagegrowthlasyyear',
					'percentagegrowthfullperiod',
				),
			),
			'reportlanguage' => array(
				ApiBase::PARAM_DFLT => 'en',
				ApiBase::PARAM_TYPE => array(
					'en',
				),
			),
		);

		if ( $this->canBeNormalised() ) {
			$params['normalized'] = false;
		}

		$select = array(
			'selectregions' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => 'string',
			),
			'selectcountries' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => 'string',
			),
			'selectwebproperties' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => 'string',
			),
			'selectprojects' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => 'string',
			),
			'selectwikis' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => 'string',
			),
			'selecteditors' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => 'string',
			),
			'selectedits' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => 'string',
			),
			'selectplatforms' => array(
				ApiBase::PARAM_ISMULTI => true,
				ApiBase::PARAM_TYPE => 'string',
			),
		);

		$params = array_merge( $params, array_intersect_key( $select, array_flip( $this->getAllowedFilters() ) ) );

		if ( isset( $params['selectwebproperties'] ) ) {
			$params['authcode'] = array(
				ApiBase::PARAM_TYPE => 'string',
			);
		}
		return $params;
	}

	public function getParamDescription() {
		return array(
			'startmonth' => 'Start month (if a range), else target month',
			'endmonth' => 'End month (if a range)',
			'normalized' => array(
				'Only applies to squidpageviews, where data for each month are recalculated to 30 days (other metrics may follow)',
				'(WMF Report Card will use normalized time series when available)',
			),
			'data' => array(
					' timeseries        - returns ordered list of value pairs, one for each month within range',
					' timeseriesindexed - like timeseries, but each month\'s value will be relative to oldest month\'s value which is always 100',
					wordwrap( ' percentagegrowthlastmonth, percentagegrowthlastyear, percentagegrowthfullperiod - growth percentages are relative to oldest' .
								'value (80->100=25%) although trivial, requesting these metrics through API ensures all clients use same calculation',
						100, "\n    "
					),
			),
			'reportlanguage' => 'Language code, used to expand region and country codes into region and country name',
			'selectregions' => array(
				'What region',
				' as - Asia Pacific',
				' c  - China',
				' eu - Europe',
				' i  - India',
				' la - Latin-America',
				' ma - Middle-East/Africa',
				' na - North-America',
				' us - United States',
				' w  - World',
			),
			'selectcountries' => array(
				'What country, based on ISO 3166-1 codes',
					/*'AF',
					'AX',
					'AL',
					'DZ',
					'AS',
					'AD',
					'AO',
					'AI',
					'AQ',
					'AG',
					'AR',
					'AM',
					'AW',
					'AU',
					'AT',
					'AZ',
					'BS',
					'BH',
					'BD',
					'BB',
					'BY',
					'BE',
					'BZ',
					'BJ',
					'BM',
					'BT',
					'BO',
					'BQ',
					'BA',
					'BW',
					'BV',
					'BR',
					'IO',
					'BN',
					'BG',
					'BF',
					'BI',
					'KH',
					'CM',
					'CA',
					'CV',
					'KY',
					'CF',
					'TD',
					'CL',
					'CN',
					'CX',
					'CC',
					'CO',
					'KM',
					'CG',
					'CD',
					'CK',
					'CR',
					'CI',
					'HR',
					'CU',
					'CW',
					'CY',
					'CZ',
					'DK',
					'DJ',
					'DM',
					'DO',
					'EC',
					'EG',
					'SV',
					'GQ',
					'ER',
					'EE',
					'ET',
					'FK',
					'FO',
					'FJ',
					'FI',
					'FR',
					'GF',
					'PF',
					'TF',
					'GA',
					'GM',
					'GE',
					'DE',
					'GH',
					'GI',
					'GR',
					'GL',
					'GD',
					'GP',
					'GU',
					'GT',
					'GG',
					'GN',
					'GW',
					'GY',
					'HT',
					'HM',
					'VA',
					'HN',
					'HK',
					'HU',
					'IS',
					'IN',
					'ID',
					'IR',
					'IQ',
					'IE',
					'IM',
					'IL',
					'IT',
					'JM',
					'JP',
					'JE',
					'JO',
					'KZ',
					'KE',
					'KI',
					'KP',
					'KR',
					'KW',
					'KG',
					'LA',
					'LV',
					'LB',
					'LS',
					'LR',
					'LY',
					'LI',
					'LT',
					'LU',
					'MO',
					'MK',
					'MG',
					'MW',
					'MY',
					'MV',
					'ML',
					'MT',
					'MH',
					'MQ',
					'MR',
					'MU',
					'YT',
					'MX',
					'FM',
					'MD',
					'MC',
					'MN',
					'ME',
					'MS',
					'MA',
					'MZ',
					'MM',
					'NA',
					'NR',
					'NP',
					'NL',
					'NC',
					'NZ',
					'NI',
					'NE',
					'NG',
					'NU',
					'NF',
					'MP',
					'NO',
					'OM',
					'PK',
					'PW',
					'PS',
					'PA',
					'PG',
					'PY',
					'PE',
					'PH',
					'PN',
					'PL',
					'PT',
					'PR',
					'QA',
					'RE',
					'RO',
					'RU',
					'RW',
					'BL',
					'SH',
					'KN',
					'LC',
					'MF',
					'PM',
					'VC',
					'WS',
					'SM',
					'ST',
					'SA',
					'SN',
					'RS',
					'SC',
					'SL',
					'SG',
					'SX',
					'SK',
					'SI',
					'SB',
					'SO',
					'ZA',
					'GS',
					'ES',
					'LK',
					'SD',
					'SR',
					'SJ',
					'SZ',
					'SE',
					'CH',
					'SY',
					'TW',
					'TJ',
					'TZ',
					'TH',
					'TL',
					'TG',
					'TK',
					'TO',
					'TT',
					'TN',
					'TR',
					'TM',
					'TC',
					'TV',
					'UG',
					'UA',
					'AE',
					'GB',
					'US',
					'UM',
					'UY',
					'UZ',
					'VU',
					'VE',
					'VN',
					'VG',
					'VI',
					'WF',
					'EH',
					'YE',
					'ZM',
					'ZW',*/
			),
			'selectwebproperties' => array(
				'',
				'This parameter requires extra authorisation.',
			),
			'selectprojects' => array(
				'Which projects',
				' wb - Wikibooks',
				' wk - Wiktionary',
				' wn - Wikinews',
				' wp - Wikipedia',
				' wq - Wikiquote',
				' ws - Wikisource',
				' wv - Wikiversity',
				' co - Commons',
				' wx - Other projects',
			),
			'selectwikis' => 'Specify each wiki code as project:language, e.g. wp:en for English Wikipedia, wq:de for German Wikiquote',
			'selecteditors' => 'a for anonymous, r for registered, b for bot',
			'selectedits' => 'm for manual, b for bot-induced',
			'selectplatform' => 'm for mobile, n for non-mobile',
			'authcode' => "Auth code needed for 'selectwebproperties'",
		);
	}

	//public abstract function getDescription();

	//protected abstract function getExamples();

	/*public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(
		) );
	}*/

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiAnalyticsBase.php 107682 2011-12-31 00:23:14Z reedy $';
	}
}
