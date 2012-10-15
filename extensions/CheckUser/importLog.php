<?php

require_once ( getenv( 'MW_INSTALL_PATH' ) !== false
	? getenv( 'MW_INSTALL_PATH' ) . "/maintenance/commandLine.inc"
	: dirname( __FILE__ ) . '/../../maintenance/commandLine.inc' );
require "cu_log_import.inc";

function test_cu_log( $log ) {
	$matched = 0;
	$unmatched = 0;
	$badtime = 0;

	$file = fopen( $log, 'r' );
	while ( false !== ( $line = fgets( $file ) ) ) {
		$data = import_cu_log_line( $line );
		if ( $data ) {
			$matched++;
			if ( !$data['timestamp'] ) {
				print "[bad timestamp] $line";
				$badtime++;
			}
		} else {
			print "[bad format] $line";
			$unmatched++;
		}
	}
	fclose( $file );
	print "\n$matched matched, $badtime matched with bad time, $unmatched unprocessed\n";
}

if ( $args ) {
	$log = $args[0];
	if ( isset( $options['test'] ) ) {
		test_cu_log( $log );
	} else {
		$dryRun = isset( $options['dry-run'] );
		if ( $dryRun ) {
			$db = false;
			echo "Dry run; no actual imports will be made...\n";
		} else {
			$db = wfGetDB( DB_MASTER );
		}
		import_cu_log( $db, $log );
	}
} else {
	echo "CheckUser old log file importer.\n";
	echo "If cu_log table has been manually added, can be used to import old data.\n";
	echo "\n";
	echo "Usage: php importLog.php [--test] [--dry-run] checkuser.log\n";
	echo "   --dry-run Parse and do local lookups, but don't perform inserts\n";
	echo "   --test    Test log parser without doing local lookups\n";
	echo "\n";
}
