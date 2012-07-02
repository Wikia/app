<?php
// pass 1:
// * generate 'globaluser' entries for each username
// * go through all usernames in 'globalnames' and for those
//   that can be automatically migrated, go ahead and do it.

$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../../..';
}
require_once( "$IP/maintenance/commandLine.inc" );

function migratePassOne() {
	$migrated = 0;
	$total = 0;
	$chunkSize = 1000;
	$start = microtime( true );

	$dbBackground = CentralAuthUser::getCentralSlaveDB();
	$result = $dbBackground->select(
		'globalnames',
		array( 'gn_name' ),
		'',
		__METHOD__ );
	foreach( $result as $row ) {
		$name = $row->gn_name;
		$central = new CentralAuthUser( $name );
		if ( $central->storeAndMigrate() ) {
			$migrated++;
		}
		if ( ++$total % $chunkSize == 0 ) {
			migratePassOneReport( $migrated, $total, $start );
		}
	}
	migratePassOneReport( $migrated, $total, $start );
	echo "DONE\n";
}

/**
 * @param $migrated
 * @param $total
 * @param $start
 */
function migratePassOneReport( $migrated, $total, $start ) {
	$delta = microtime( true ) - $start;
	printf( "%s processed %d usernames (%.1f/sec), %d (%.1f%%) fully migrated\n",
		wfTimestamp( TS_DB ),
		$total,
		$total / $delta,
		$migrated,
		$migrated / $total * 100.0 );
}

echo "CentralAuth migration pass 1:\n";
echo "Finding accounts which can be migrated without interaction...\n";
migratePassOne();
echo "done.\n";
