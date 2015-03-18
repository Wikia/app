<?php

/**
 * sendWeeklyDigest
 *
 * This script sends the weekly digest to the users found in the global_watchlist table found
 * in the dataware database. For more information, see the README found in the GlobalWatchlist
 * extension. Additional logging can be found on the Weekly Digest dashboard:
 * https://kibana.wikia-inc.com/#/dashboard/elasticsearch/Weekly%20Digest
 *
 * @author james@wikia-inc.com
 * @ingroup Maintenance
 */

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_ALL );

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Class sendWeeklyDigest
 */
class sendWeeklyDigest extends Maintenance {

	private $dryRun = false;

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Send the weekly digest";
		$this->addOption( 'dryRun', 'Do a test run of the script without actually sending the digest', false, false, 'd' );
	}

	public function execute() {
		$this->dryRun = $this->hasOption( "dryRun" );

		$this->logRunTime();
		$userIDs = $this->getUserIDs();
		$this->sendDigestToUsers( $userIDs );
	}

	private function getUserIDs() {
		$db = wfGetDB( DB_SLAVE, [], \F::app()->wg->ExternalDatawareDB );
		$userIDs = ( new WikiaSQL() )
			->SELECT()->DISTINCT( GlobalWatchlistTable::COLUMN_USER_ID )
			->FROM( GlobalWatchlistTable::TABLE_NAME )
			->runLoop( $db, function ( &$userIDs, $row ) {
				$userIDs[] = $row->gwa_user_id;
			} );

		return $userIDs;
	}

	private function sendDigestToUsers( array $userIDs ) {
		$watchlistTask = new GlobalWatchlistTask();
		foreach ( $userIDs as $userID ) {
			$this->output( "Sending weekly digest to user: " . $userID . "\n" );
			if ( !$this->isDryRun() ) {
				$watchlistTask->sendWeeklyDigest( $userID );
			}
		}
	}

	private function logRunTime() {
		$message = "sendWeeklyDigest script run at " . date( "F j, Y, g:i a" ) . "\n";
		$this->output( $message );
	}

	private function isDryRun() {
		return $this->dryRun;
	}
}

$maintClass = "sendWeeklyDigest";
require_once( RUN_MAINTENANCE_IF_MAIN );
