<?php

/**
 * Script that removes entries for closed wikis from:
 *  - specials.events_local_users table
 *  - stats.events table
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
class EventsCleanup extends Maintenance {

	const BATCH = 50;

	// remove entries for wikis closed before this date
	const CLOSED_BEFORE = '20130101000000';

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'This script removes entries from events-related tables';
	}

	/**
	 * Perform a cleanup for a set of wikis
	 *
	 * @param DatabaseBase $db database handler
	 * @param string $table name of table to clean up
	 * @param string $wiki_id_colunmn table column name to use when querying for wiki ID
	 * @param Array $city_ids IDs of wikis to remove from the table
	 */
	private function doTableCleanup( DatabaseBase $db, $table, Array $city_ids, $wiki_id_colunmn = 'wiki_id' ) {
		$start = microtime( true );

		$db->delete( $table, [ $wiki_id_colunmn => $city_ids ], __METHOD__ );
		$rows = $db->affectedRows();

		// just in case MW decides to start a transaction automagically
		$db->commit( __METHOD__ );

		Wikia\Logger\WikiaLogger::instance()->info( __METHOD__, [
			'table' => $table,
			'cities' => join( ', ', $city_ids ),
			'count' => count( $city_ids ),
			'took' => round( microtime( true ) - $start, 4 ),
			'rows' => $rows
		] );

		$this->output( sprintf ( "%s: %s - removed %d rows\n", date( 'Y-m-d H:i:s' ), $table, $rows ) );

		// throttle delete queries
		if ( $rows > 0 ) {
			sleep( 5 );
		}
	}

	private function cleanupBatch( Array $city_ids ) {
		global $wgSpecialsDB, $wgStatsDB;
		$specials = wfGetDB( DB_MASTER, [], $wgSpecialsDB );
		$stats = wfGetDB( DB_MASTER, [], $wgStatsDB );

		$this->doTableCleanup( $specials, 'events_local_users', $city_ids );
		$this->doTableCleanup( $stats, 'events', $city_ids );
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
			$this->cleanupBatch( $batch );
		}

		$this->output( "\nDone\n" );
	}
}

$maintClass = "EventsCleanup";
require_once( RUN_MAINTENANCE_IF_MAIN );
