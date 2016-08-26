<?php

/**
 * Maintenance script to remove real-world <imap /> tags from articles
 *
 * @usage SERVER_ID=203236 php removeImapTags.php --tiles-set-id=123 --dry-run
 */

ini_set( "include_path", dirname( __FILE__ )."/../../" );

require_once( "commandLine.inc" );

global $wgCityId;

$displayHelp = isset( $options['help'] );
$dryRun = isset( $options['dry-run'] );
$tilesSetId = isset( $options['tiles-set-id'] ) ? $options['tiles-set-id'] : -1;

function isValidTilesSetId( $tilesSetId ) {
	$tilesSetId = intval( $tilesSetId );

	if( $tilesSetId <= 0 ) {
		return false;
	}

	return true;
}

function printMsg( $msg ) {
	echo $msg . PHP_EOL;
}

function run( $tilesSetId, $displayHelp, $dryRun ) {
	if ( $displayHelp ) {
		die(
		<<<TXT
		Usage: php removeImapTags.php [--help] [--dry-run] --tiles-set-id
--tiles-set-id		tiles-set-id used by maps which thumbnails are supposed to be removed
--dry-run		dry run - prints information to the output but does not modify data
--help			you are reading it right now

TXT
		);
	}

	if ( !isValidTilesSetId( $tilesSetId ) ) {
		printMsg( 'Invalid tiles-set-id. Try again.' );
		die;
	}

	if ( $dryRun ) {
		printMsg( 'Mode: dry-run' );
	} else {
		printMsg( 'Mode: normal' );
	}

	printMsg( 'Done.' );
}

run( $tilesSetId, $displayHelp, $dryRun );
