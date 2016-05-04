<?php

use \Wikia\Logger\WikiaLogger;

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
	const BATCH_SIZE = 100;

	const PARAM_IDS = 'ids';

	public function __construct() {
		parent::__construct();
		$this->addOption( self::PARAM_IDS, 'User IDs to process in this batch, comma separated list', false, /* withArgs */
			true );
		$this->mDescription = "Send the weekly digest";
	}

	public function execute() {
		$userIds = $this->getOption( self::PARAM_IDS );
		if ( !$userIds ) {
			$this->executeAll();
		} else {
			$userIds = explode( ',', $userIds );
			$userIds = array_map( 'intval', $userIds );
			$this->executeBatch( $userIds );
		}
	}

	private function executeAll() {
		$this->logRunTime( 'main' );
		$watchlistBot = new GlobalWatchlistBot();
		try {
			$this->output( "Fetching list of users...\n" );
			$ids = $watchlistBot->getUserIDs();
			$this->output( "Received " . count( $ids ) . " users to process.\n" );
			$batches = array_chunk( $ids, self::BATCH_SIZE );
			foreach ( $batches as $batch ) {
				$this->spawnBatch( $batch );
			}
			$this->output( "Finished all batches successfully.\n");
		} catch ( Exception $e ) {
			$this->logError( $e );
		}
	}

	private function executeBatch( array $ids ) {
		$this->logRunTime( "batch starting at user id ${ids[0]}" );
		$watchlistBot = new GlobalWatchlistBot();
		try {
			foreach ( $ids as $id ) {
				$watchlistBot->sendWeeklyDigestForUserId( $id );
			}
		} catch ( Exception $e ) {
			$this->logError( $e );
		}
	}

	private function spawnBatch( array $batch ) {
		global $wgCityId;

		$idsText = implode( ',', $batch );

		$this->output( "Spawning batch for $idsText...\n" );

		$command = "SERVER_ID={$wgCityId} php " . __FILE__ . " ";
		$command .= "--" . self::PARAM_IDS . "=" . $idsText;

		$retval = null;
		$log = wfShellExec( $command, $retval );
		if ( $retval ) {
			$this->output( $log . "\n" );
			$this->output( "Batch failed, error code returned: $retval\n" );
			$this->logError( new Exception( "Batch $idsText failed, error code returned: $retval, Error was: $log \n" ) );
		} else {
			$this->output( $log . "\n" );
			$this->output( "Batch executed successfully.\n");
		}
	}

	private function logRunTime( $processName ) {
		$processName = $processName ? "[$processName] " : '';
		$message = "Started sendWeeklyDigest.php ${processName}at " . date( "F j, Y, g:i a" ) . "\n";
		$this->output( $message );
	}

	/**
	 * If there's a problem when sending the weekly digest (ie, timing out), log the error. We have
	 * a Kibana check which will send out an alert if any "Weekly Digest Error" messages are sent.
	 */
	private function logError( Exception $exception ) {
		WikiaLogger::instance()->error( 'Weekly Digest Error', [
			'exception' => $exception->getMessage(),
		] );
	}
}

$maintClass = "sendWeeklyDigest";
require_once( RUN_MAINTENANCE_IF_MAIN );
