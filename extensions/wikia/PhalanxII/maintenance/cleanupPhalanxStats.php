<?php

require_once __DIR__ . '/../../../../maintenance/Maintenance.php';

/**
 * Script that removes specials.phalanx_stats entries that are older than 365 days
 *
 * @see SUS-3388
 * @author macbre
 * @file
 * @ingroup Maintenance
 */
class CleanupPhalanxStats extends Maintenance {

	function execute() {

		global $wgSpecialsDB;

		$db = wfGetDB( DB_MASTER, [], $wgSpecialsDB );
		$rows = 0;

		do {

			// delete entries older than 365 days in small batches
			// ps_timestamp has MediaWiki-formatted timestamps, e.g. 20170101000000
			$db->query( 'DELETE FROM phalanx_stats WHERE ps_timestamp < NOW() - INTERVAL 365 DAY LIMIT 5000', __METHOD__ );
			$affectedRows = $db->affectedRows();

			$rows +=  $affectedRows;

			wfWaitForSlaves( $db->getDBname() );

			echo '.';

		} while ( $affectedRows > 0 );

		// every week we remove ~150k rows
		\Wikia\Logger\WikiaLogger::instance()->info( "Count of rows dropped from phalanx stats: $rows" );
	}
}
