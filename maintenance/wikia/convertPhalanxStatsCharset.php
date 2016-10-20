<?php
/**
 * One-time script to convert charset of phalanx_stats to latin1
 * The reason is all the connections in MW open with latin1 and cause improperly decoding
 *
 * @package MediaWiki
 * @subpackage Maintanance
 *
 * @author Armon Rabiyan <armon at fandom.com>
 *
 */

require_once( dirname( __FILE__ ) . '/../commandLine.inc' );

if ( isset( $options['help'] ) ) {
	die( "Usage: php convertPhalanxStatsCharset.php [--help] [--dry-run] [--verbose]
	--dry-run       dry run
	--verbose       be verbose
	--help          you are reading it right now\n\n" );
}

$startTime = microtime( true );

$dryRun = isset( $options['dry-run'] );

$schema = 'specials';
$table = 'phalanx_stats';
$alterCharset = "ALTER TABLE $table CONVERT TO CHARACTER SET latin1;";

if ( isset( $options['verbose'] ) ) {
	echo( "Executing query on $schema.$table: $alterCharset ...\n" );
}

if ( !$dryRun ) {
	$dbw = wfGetDB( DB_MASTER, [], $schema );

	wfWaitForSlaves();

	$dbw->query( $alterCharset );
	$dbw->commit();
} else {
	echo "dry-run mode; no changes were made!";
}

$elapsedTime = (microtime( true ) - $startTime) / 1000.;
echo "\n-- Execution time: $elapsedTime ms\n";
