<?php

/**
 * Script that removes wikicities.shared_newtalks entries that are older than 90 days
 *
 * @see SUS-3090
 * @author macbre
 * @file
 * @ingroup Maintenance
 */

require_once( __DIR__ . '/../../../../maintenance/commandLine.inc' );

$db = wfGetDB( DB_MASTER, [], $wgExternalSharedDB );
$rows = 0;

do {

	// delete entries older than 90 days in small batches
	$db->query( 'DELETE FROM shared_newtalks WHERE sn_date < NOW() - INTERVAL 90 DAY LIMIT 500', __FILE__ );
	$affectedRows = $db->affectedRows();

	$rows +=  $affectedRows;

	wfWaitForSlaves( $db->getDBname() );

} while ( $affectedRows > 0 );

echo sprintf( "%s: dropped %d rows from shared_newtalks\n", date( 'r' ), $rows );
