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

require_once( dirname( __FILE__ ) . '/../../Maintenance.php' );

/**
 * Class sendWeeklyDigest
 */
class sendWeeklyDigest extends Maintenance {

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Send the weekly digest";
	}

	public function execute() {
		$this->logRunTime();
		$watchlistBot = new GlobalWatchlistBot();
		$watchlistBot->sendWeeklyDigest();
	}

	private function logRunTime() {
		$message = "sendWeeklyDigest script run at " . date( "F j, Y, g:i a" ) . "\n";
		$this->output( $message );
	}
}

$maintClass = "sendWeeklyDigest";
require_once( RUN_MAINTENANCE_IF_MAIN );
