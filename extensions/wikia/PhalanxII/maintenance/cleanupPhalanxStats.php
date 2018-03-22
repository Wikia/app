<?php

/**
 * Script that removes specials.phalanx_stats entries that are older than 365 days
 *
 * @see SUS-3388
 * @author macbre
 * @file
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../../../../maintenance/commandLine.inc' );

$db = wfGetDB( DB_MASTER, [], $wgSpecialsDB );
$rows = 0;

do {

	// delete entries older than 365 days in small batches
	// ps_timestamp has MediaWiki-formatted timestamps, e.g. 20170101000000
	$db->query( 'DELETE FROM phalanx_stats WHERE ps_timestamp < NOW() - INTERVAL 365 DAY LIMIT 5000', __FILE__ );
	$affectedRows = $db->affectedRows();

	$rows +=  $affectedRows;

	wfWaitForSlaves( $db->getDBname() );

	echo '.';

} while ( $affectedRows > 0 );

echo sprintf( "\n%s: dropped %d rows from phalanx_stats\n", date( 'r' ), $rows );
