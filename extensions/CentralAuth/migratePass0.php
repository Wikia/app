<?php

// --> disable account creations, password changes
// pass 0:
// * generate 'globalnames' and 'localnames' entries for each user on each wiki
// --> enable

require dirname(__FILE__) . '/../../maintenance/commandLine.inc';

/**
 * Copy user data for this wiki into the localuser table
 */
function migratePassZero() {
	global $wgDBname;
	$dbr = wfGetDB( DB_SLAVE );
	$chunkSize = 1000;

	$start = microtime( true );
	$migrated = 0;

	// List all user accounts on this wiki in the migration table
	// on the central authentication server.

	$lastUser = $dbr->selectField( 'user', 'MAX(user_id)', '', __FUNCTION__ );
	for( $min = 0; $min <= $lastUser; $min += $chunkSize ) {
		$max = $min + $chunkSize;
		$result = $dbr->select( 'user',
			array( 'user_id', 'user_name' ),
			"user_id BETWEEN $min AND $max",
			__FUNCTION__ );

		while( $row = $dbr->fetchObject( $result ) ) {
			$users[intval($row->user_id)] = $row->user_name;
			++$migrated;
		}
		$dbr->freeResult( $result );

		CentralAuthUser::storeMigrationData( $wgDBname, $users );

		$delta = microtime( true ) - $start;
		$rate = ($delta == 0.0) ? 0.0 : $migrated / $delta;
		printf( "%s %d (%0.1f%%) done in %0.1f secs (%0.3f accounts/sec).\n",
			$wgDBname,
			$migrated,
			min( $max, $lastUser ) / $lastUser * 100.0,
			$delta,
			$rate );
	}
}

function getEditCount( $userId ) {
	return countEdits( $userId, 'revision', 'rev_user' );
}

function countEdits( $userId, $table, $field ) {
	$dbr = wfGetDB( DB_SLAVE );
	$count = $dbr->selectField( $table, 'COUNT(*)',
		array( $field => $userId ),
		__METHOD__ );
	return intval( $count );
}

echo "CentralAuth migration pass 0:\n";
echo "$wgDBname preparing migration data...\n";
migratePassZero();
echo "done.\n";
