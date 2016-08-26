<?php

/**
 * Maintenance script to remove real-world <imap /> tags from articles
 */

ini_set( "include_path", dirname( __FILE__ )."/../../" );

require_once( "commandLine.inc" );

$displayHelp = isset( $options['help'] );
$dryRun = isset( $options['help'] );
$cityId = $options['city-id'];

function isValidCityId($cityId) {
	$cityId = intval($cityId);

	if( $cityId <= 0 ) {
		return false;
	}

	return true;
}

function run( $cityId, $displayHelp, $dryRun ) {
	if ( $displayHelp ) {
		die(
		<<<TXT
		Usage: php imapTags.php [--help] [--dry-run] [--city-id]
--dry-run		dry run - prints information to the output but does not modify data
--help			you are reading it right now

TXT
		);
	}

	if ( !isValidCityId($cityId) ) {
		die("Invalid city-id. Try again.");
	}

	if ( $dryRun ) {
		echo 'mode: dry run' . PHP_EOL;
	}

	echo 'Done.' . PHP_EOL;
}

run( $cityId, $displayHelp, $dryRun );
