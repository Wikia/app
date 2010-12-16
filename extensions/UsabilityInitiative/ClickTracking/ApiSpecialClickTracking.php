<?php
/**
 * Extend the API for click tracking visualization in the special:clicktracking page
 *
 * @file
 * @ingroup API
 */

class ApiSpecialClickTracking extends ApiBase {

	/**
	 * runs when the API is called with "specialclicktracking", takes in "startdate" and "enddate" as YYYYMMDD , "eventid" as the event ID,
	 *     and "increment" as how many days to increment
	 * @see includes/api/ApiBase#execute()
	 */
	public function execute() {
		$params = $this->extractRequestParams();
		$this->validateParams( $params );
		$event_id = $params['eventid'];
		$startdate = $params['startdate'];
		$enddate = $params['enddate'];
		$increment = $params['increment'];
		$userDefString = $params['userdefs'];

		// this is if it's asking for tableData
		if ( isset( $params['tabledata'] ) ) {
			$tableData = SpecialClickTracking::buildRowArray( $startdate, $enddate, $userDefString );
			$this->getResult()->addValue( array( 'tablevals' ), 'vals', $tableData );
		} else { // chart data
			$click_data = array();
			try {
				$click_data = SpecialClickTracking::getChartData( $event_id, $startdate, $enddate, $increment, $userDefString );
				$this->getResult()->addValue( array( 'datapoints' ), 'expert', $click_data['expert'] );
				$this->getResult()->addValue( array( 'datapoints' ), 'basic', $click_data['basic'] );
				$this->getResult()->addValue( array( 'datapoints' ), 'intermediate', $click_data['intermediate'] );
			} catch ( Exception $e ) { /* no result */ }
		}
	}

	/**
	 * Required parameter check
	 * @param $params params extracted from the POST
	 */
 	protected function validateParams( $params ) {
		$required = array( 'eventid', 'startdate', 'enddate', 'increment', 'userdefs' );
		foreach ( $required as $arg ) {
			if ( !isset( $params[$arg] ) ) {
				$this->dieUsageMsg( array( 'missingparam', $arg ) );
			}
		}

		// check if event id parses to an int greater than zero
		if ( (int) $params['eventid'] < 0 ) {
			$this->dieUsage( 'Invalid event ID', 'badeventid' );
		}

		// check start and end date are of proper format
		if ( $params['startdate'] != 0 && strptime( SpecialClickTracking::space_out_date( $params['startdate'] ), "%Y %m %d" ) === false ) {
			$this->dieUsage( "startdate not in YYYYMMDD format: <<{$params['startdate']}>>", 'badstartdate' );
		}
 		if ( $params['enddate'] != 0 && strptime( SpecialClickTracking::space_out_date( $params['enddate'] ), "%Y %m %d" ) === false ) {
			$this->dieUsage( "enddate not in YYYYMMDD format: <<{$params['enddate']}>>", 'badenddate' );
		}

		// check if increment is a positive int
 		if ( (int) $params['increment'] <= 0 ) {
			$this->dieUsage( 'Invalid increment', 'badincrement' );
		}

		if ( json_decode( $params['userdefs'] ) == null ) {
			$this->dieUsage( "Invalid JSON encoding <<{$params['userdefs']}>>", 'badjson' );
		}
	}

	public function getParamDescription() {
		return array(
			'eventid' => 'event ID (number)',
			'startdate'  => 'start date for data in YYYYMMDD format',
			'enddate' => 'end date for the data in YYYYMMDD format',
			'increment' => 'increment interval (in days) for data points',
			'userdefs' => 'JSON object to encode user definitions',
			'tabledata' => 'set to 1 for table data instead of chart data'
		);
	}

	public function getDescription() {
		return array(
			'Returns data to the Special:ClickTracking visualization page'
		);
	}
	
	public function getPossibleErrors() {
		return array_merge( parent::getPossibleErrors(), array(	
			array( 'missingparam', 'eventid' ),
			array( 'missingparam', 'startdate' ),
			array( 'missingparam', 'enddate' ),
			array( 'missingparam', 'increment' ),
			array( 'missingparam', 'userdefs' ),
			array( 'code' => 'badeventid', 'info' => 'Invalid event ID' ),
			array( 'code' => 'badstartdate', 'info' => 'startdate not in YYYYMMDD format: <<\'startdate\'>>' ),
			array( 'code' => 'badenddate', 'info' => 'enddate not in YYYYMMDD format: <<\'enddate\'>>' ),
			array( 'code' => 'badincrement', 'info' => 'Invalid increment' ),
			array( 'code' => 'badjson', 'info' => 'Invalid JSON encoding <<\'userdefs\'>>' ),
		) );
	}

	public function getAllowedParams() {
		return array(
			'eventid' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_MIN => 1
			),
			'startdate' => array(
				ApiBase::PARAM_TYPE => 'integer'
			),
			'enddate' => array(
				ApiBase::PARAM_TYPE => 'integer'
			),
			'increment' => array(
				ApiBase::PARAM_TYPE => 'integer',
				ApiBase::PARAM_MIN => 1,
				ApiBase::PARAM_MAX => 365 // 1 year
			),
			'userdefs' => array(
				ApiBase::PARAM_TYPE => 'string'
			),
			'tabledata' => array(
				ApiBase::PARAM_TYPE => 'integer'
			),
		);
	}

	public function getVersion() {
		return __CLASS__ . ': $Id: ApiSpecialClickTracking.php 62619 2010-02-16 23:34:27Z reedy $';
	}

}