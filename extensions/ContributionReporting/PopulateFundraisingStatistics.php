<?php

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../..';
}
require_once( "$IP/maintenance/Maintenance.php" );

class PopulateFundraisingStatistics extends Maintenance {
	/**
	 * DB slave
	 * @var object
	 */
	protected $dbr;

	/**
	 * DB master
	 * @var object
	 */
	protected $dbw;

	/**
	 * Valid operations and their execution methods for this script to perform
	 *
	 * Operations are passed in as options during run-time - only valid options,
	 * which are defined here, can be executed. Valid operations are mapped here
	 * to a corresponding method ( array( 'operation' => 'method' ))
	 * @var array
	 */
	protected $operation_map = array(
		'populatedays' => 'populateDays',
		'populatefundraisers' => 'populateFundraisers',
		'updatedays' => 'updateDays',
	);

	/**
	 * Operations to execute
	 * @var array
	 */
	public $operations = array();

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Populates the public reporting summary tables";

		$this->addOption( 'op', 'The ContributionReporting stats gathering operation to run (e.g. "updatedays").  Can specify multiple operations, separated by comma.', true, true );
	}

	/**
	 * Bootstrap this maintenance script
	 *
	 * Performs operations necessary for this maintenance script to run which
	 * cannot or do not make sense to run in the constructor.
	 */
	public function bootstrap() {
		/**
		 * Set user-specified operations to perform
		 */
		$operations = explode( ',', $this->getOption( 'op' ) );
		// Check sanity of specified operations
		if ( !$this->checkOperations( $operations ) ) {
			$this->error( 'Invalid operation specified.', true );
		} else {
			$this->operations = $operations;
		}

		// Set database objects
		$this->dbr = wfGetDB( DB_SLAVE );
		$this->dbw = wfGetDB( DB_MASTER );
		$this->dbpr = efContributionReportingReadConnection();
		
		// Set timezone to UTC (contribution data will always be in UTC)
		date_default_timezone_set( 'UTC' );
	}

	/**
	 * Check whether or not specified operations are valid.
	 *
	 * A specified operation is considered valid if it exists
	 * as a key in the operation map.
	 *
	 * @param array $ops An array of operations to check
	 * @return bool
	 */
	public function checkOperations( array $ops ) {
		foreach ( $ops as $operation ) {
			if ( !isset( $this->operation_map[ $operation ] ) ) {
				return false;
			}
		}
		return true;
	}

	public function execute() {
		// finish bootstrapping the script
		$this->bootstrap();

		// execute requested operations
		foreach ( $this->operations as $operation ) {
			$method = $this->operation_map[ $operation ];
			$this->$method();
		}
	}

	/**
	 * Populate the donation stats for every day
	 *
	 * Note that these summaries exclude amounts that are not between the mimumum and maximum
	 * donation amounts. This is because every once in a while we have to condense multiple
	 * donations that may span several days into a single donation for CiviCRM consumption.
	 */
	public function populateDays() {
		global $egFundraiserStatisticsMinimum, $egFundraiserStatisticsMaximum;

		$begin = time();
		$records = 0;
		$insertArray = array();
		$this->output( "Writing data to public_reporting_days...\n" );
		
		$conditions = array(
			'converted_amount >= ' . intval( $egFundraiserStatisticsMinimum ),
			'converted_amount <= ' . intval( $egFundraiserStatisticsMaximum )
		);
		
		// Get the data for a fundraiser
		$result = $this->dbpr->select( 'public_reporting',
			array(
				"DATE_FORMAT( FROM_UNIXTIME( received ),'%Y-%m-%d' ) AS date",
				'sum( converted_amount ) AS total',
				'count( * ) AS number',
				'avg( converted_amount ) AS average',
				'max( converted_amount ) AS maximum',
			),
			$conditions,
			__METHOD__,
			array(
				'ORDER BY' => 'received',
				'GROUP BY' => "DATE_FORMAT( FROM_UNIXTIME( received ),'%Y-%m-%d' )"
			)
		);
		
		while ( $row = $this->dbpr->fetchRow( $result ) ) {
			// Add it to the insert array
			$insertArray[] = array(
				'prd_date' => $row['date'],
				'prd_total' => $row['total'],
				'prd_number' => $row['number'],
				'prd_average' => $row['average'],
				'prd_maximum' => $row['maximum'],
				'prd_insert_timestamp' => time(),
			);
			$records++;
		}
		
		if ( $records > 0 ) {
			// Empty the table of previous totals
			$res = $this->dbw->delete( 'public_reporting_days', array( 1 ) );
			// Insert the new totals
			$res = $this->dbw->insert( 'public_reporting_days', $insertArray, __METHOD__ );
			// Wait for the databases to sync
			wfWaitForSlaves();
		}
		
		$lag = time() - $begin;
		$this->output( "Inserted " . $records . " rows. ($lag seconds)\n" );
		$this->output( "Done.\n" );
	}

	/**
	 * Populate the cumulative donation stats for all fundraisers
	 *
	 * Note that we do not build these stats from the daily summaries since the summaries exclude
	 * amounts that are not between the minumum and maximum donation amounts.
	 */
	public function populateFundraisers() {
		global $egFundraiserStatisticsFundraisers;

		$begin = time();
		$records = 0;
		$insertArray = array();
		$this->output( "Writing data to public_reporting_fundraisers...\n" );
		foreach ( $egFundraiserStatisticsFundraisers as $fundraiser ) {
		
			$conditions = array(
				'received >= ' . $this->dbpr->addQuotes( wfTimestamp( TS_UNIX, strtotime( $fundraiser['start'] ) ) ),
				'received <= ' . $this->dbpr->addQuotes( wfTimestamp( TS_UNIX, strtotime( $fundraiser['end'] ) + 24 * 60 * 60 ) ),
			);
			
			// Get the total for a fundraiser
			$result = $this->dbpr->select(
				'public_reporting',
				array(
					'sum( converted_amount ) AS total',
					'count( * ) AS number',
					'avg( converted_amount ) AS average',
					'max( converted_amount ) AS maximum',
				),
				$conditions,
				__METHOD__
			);
			$row = $this->dbpr->fetchRow( $result );
		
			// Add it to the insert array
			$insertArray[] = array(
				'prf_id' => $fundraiser['id'],
				'prf_total' => $row['total'],
				'prf_number' => $row['number'],
				'prf_average' => $row['average'],
				'prf_maximum' => $row['maximum'],
				'prf_insert_timestamp' => time(),
			);
			
			$records++;
		}
		if ( $records > 0 ) {
			// Empty the table of previous totals
			$res = $this->dbw->delete( 'public_reporting_fundraisers', array( 1 ) );
			// Insert the new totals
			$res = $this->dbw->insert( 'public_reporting_fundraisers', $insertArray, __METHOD__ );
			// Wait for the databases to sync
			wfWaitForSlaves();
		}
		$lag = time() - $begin;
		$this->output( "Inserted " . $records . " rows. ($lag seconds)\n" );
		$this->output( "Done.\n" );
	}
	
	/**
	 * Populate the donation stats for every day of the current fundraiser
	 *
	 * Note that if you are running more than one fundraiser at once, you'll want to use 
	 * populateDays instead of updateDays.
	 * Note that these summaries exclude amounts that are not between the mimumum and maximum
	 * donation amounts. This is because every once in a while we have to condense multiple
	 * donations that may span several days into a single donation for CiviCRM consumption.
	 */
	public function updateDays() {
		global $egFundraiserStatisticsFundraisers, $egFundraiserStatisticsMinimum, $egFundraiserStatisticsMaximum;

		$mostRecentFundraiser = end( $egFundraiserStatisticsFundraisers );
		$start = $mostRecentFundraiser['start'];
		$end = $mostRecentFundraiser['end'];
		$begin = time();
		$records = 0;
		$insertArray = array();
		$this->output( "Writing data to public_reporting_days...\n" );
		
		$conditions = array(
			'received >= ' . $this->dbpr->addQuotes( wfTimestamp( TS_UNIX, strtotime( $start ) ) ),
			'received <= ' . $this->dbpr->addQuotes( wfTimestamp( TS_UNIX, strtotime( $end ) + 24 * 60 * 60 ) ),
			'converted_amount >= ' . $egFundraiserStatisticsMinimum,
			'converted_amount <= ' . $egFundraiserStatisticsMaximum
		);
		
		// Get the data for a fundraiser
		$result = $this->dbpr->select( 'public_reporting',
			array(
				"DATE_FORMAT( FROM_UNIXTIME( received ),'%Y-%m-%d' ) AS date",
				'sum( converted_amount ) AS total',
				'count( * ) AS number',
				'avg( converted_amount ) AS average',
				'max( converted_amount ) AS maximum',
			),
			$conditions,
			__METHOD__,
			array(
				'ORDER BY' => 'received',
				'GROUP BY' => "DATE_FORMAT( FROM_UNIXTIME( received ),'%Y-%m-%d' )"
			)
		);
		
		while ( $row = $this->dbpr->fetchRow( $result ) ) {
			// Add it to the insert array
			$insertArray[] = array(
				'prd_date' => $row['date'],
				'prd_total' => $row['total'],
				'prd_number' => $row['number'],
				'prd_average' => $row['average'],
				'prd_maximum' => $row['maximum'],
				'prd_insert_timestamp' => time(),
			);
			$records++;
		}
		
		if ( $records > 0 ) {
			// Empty the table of previous totals for this fundraiser
			$res = $this->dbw->delete(
				'public_reporting_days', 
				array(
					'prd_date >= ' . $this->dbpr->addQuotes( wfTimestamp( TS_DB, strtotime( $start ) ) ),
					'prd_date <= ' . $this->dbpr->addQuotes( wfTimestamp( TS_DB, strtotime( $end ) ) ),
				)
			);
			// Insert the new totals
			$res = $this->dbw->insert( 'public_reporting_days', $insertArray, __METHOD__ );
			// Wait for the databases to sync
			wfWaitForSlaves();
		}
		
		$lag = time() - $begin;
		$this->output( "Updated " . $records . " rows. ($lag seconds)\n" );
		$this->output( "Done.\n" );
	}

}

$maintClass = "PopulateFundraisingStatistics";
require_once( DO_MAINTENANCE );
