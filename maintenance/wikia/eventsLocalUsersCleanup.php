<?php

/**
 * Script that removes entries for closed wikis from
 * specials.events_local_users table
 *
 * @see PLATFORM-1173
 *
 * @author Macbre
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

/**
 * Maintenance script class
 */
class EventsLocalUsersCleanup extends Maintenance {

	const BATCH = 25;

	// remove entries for wikis closed before this date
	const CLOSED_BEFORE = '20100101000000';

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'This script removes entries from specials.events_local_users';
	}

	/**
	 * Perform a cleanup for a set of wikis
	 *
	 * @param Array $city_ids IDs of wikis to remove from events_local_users
	 * @return int rows removed
	 */
	private function cleanupBatch( Array $city_ids ) {
		global $wgSpecialsDB;
		$start = time();

		$specials = wfGetDB( DB_MASTER, [], $wgSpecialsDB );
		$specials->delete(
			'events_local_users',
			[
				'wiki_id' => $city_ids
			],
			__METHOD__
		);
		$rows = $specials->affectedRows();

		// just in case MW decides to start a transaction automagically
		$specials->commit( __METHOD__ );

		Wikia\Logger\WikiaLogger::instance()->info( __METHOD__, [
			'cities' => join( ', ', $city_ids ),
			'count' => count( $city_ids ),
			'took' => time() - $start,
			'rows' => $rows
		] );

		// throttle delete queries
		if ( $rows > 0 ) {
			sleep( 5 );
		}

		return $rows;
	}

	public function execute() {
		// get all closed wikis
		$WF_db = WikiFactory::db( DB_SLAVE );

		$closedWikis = $WF_db->selectFieldValues(
			'city_list',
			'city_id',
			[
				'city_public' => WikiFactory::CLOSE_ACTION,
				sprintf( 'city_lastdump_timestamp < "%s"', self::CLOSED_BEFORE )
			],
			__METHOD__
		);

		$batches = array_chunk( $closedWikis, self::BATCH );
		$this->output( sprintf( "Got %d closed wikis (before %s) in %d batches\n", count( $closedWikis ), self::CLOSED_BEFORE, count( $batches ) ) );

		foreach ( $batches as $n => $batch ) {
			$rows = $this->cleanupBatch( $batch );
			$this->output( sprintf( "%s: batch #%d: rows removed: %d\n", date( 'Y-m-d H:i:s' ), ($n+1), $rows ) );
		}

		$this->output( "\nDone\n" );
	}
}

$maintClass = "EventsLocalUsersCleanup";
require_once( RUN_MAINTENANCE_IF_MAIN );
