<?php

/*
 * Maintenance script to delete video by provider
 * This is one time use script
 * @author Saipetch Kongkatong
 */

function printText( $text ) {
	global $quiet;

	if ( !$quiet ) {
		echo $text;
	}
}

// ----------------------------- Main ------------------------------------

ini_set( "include_path", dirname( __FILE__ )."/../../" );

require_once( "commandLine.inc" );

if ( isset( $options['help'] ) ) {
	die( "Usage: php deleteVideo.php [--help] [--dry-run] [--quiet] [--provider=xyz] [--extra=xyz] [--limit=123]
	--provider                     specify provider (required)
	--extra                        extra condition for where clause in sql. Pass 'none' if not needed. (required)
	--limit                        number of limit in sql
	--dry-run                      dry run
	--quiet                        show summary result only
	--help                         you are reading it right now\n\n" );
}

$provider = isset( $options['provider'] ) ? $options['provider'] : '';
$extra = isset( $options['extra'] ) ? $options['extra'] : '';
$limit = isset( $options['limit'] ) ? $options['limit'] : '';
$dryRun = isset( $options['dry-run'] );
$quiet = isset( $options['quiet'] );

if ( empty( $wgCityId ) ) {
	die( "Error: Invalid wiki id.\n" );
}

echo "Wiki: $wgCityId\n";

if ( empty( $provider ) ) {
	die( "Error: Invalid provider.\n" );
}

echo "Provider: $provider\n";

if ( empty( $extra ) ) {
	die( "Error: Invalid extra condition.");
}

echo "Extra condition: $extra\n";

$wgUser = User::newFromName( 'WikiaBot' );
$wgUser->load();

$db = wfGetDB( DB_SLAVE );

// set where clause in sql
$sqlWhere = array(
	'img_media_type' => 'VIDEO',
	'img_minor_mime' => $provider,
);

if ( $extra != 'none' ) {
	$sqlWhere[] = $extra;
}

// set limit in sql
$sqlOptions = array();
if ( !empty( $limit ) && is_numeric( $limit ) ) {
	echo "Limit: $limit\n";
	$sqlOptions['LIMIT'] = $limit;
}

// get list of videos
$result = $db->select(
	array( 'image' ),
	array( '*' ),
	$sqlWhere,
	__METHOD__,
	$sqlOptions
);

$cnt = 0;
$success = 0;
while( $row = $db->fetchObject( $result ) ) {
	$name = $row->img_name;
	printText( "\tVideo: $name" );

	if ( !$dryRun ) {
		// remove video
		$response = F::app()->sendRequest( 'VideoHandlerController', 'removeVideo', array( 'title' => $name ) );
		$ret = $response->getVal( 'result', '' );
	} else {
		$ret = 'ok';
	}

	if ( $ret == 'ok' ) {
		printText( "... DONE\n" );
		$success++;
	} else {
		printText( "... Error: cannot remove video (".$response->getVal( 'msg', '' ).")\n" );
	}

	$cnt++;
}

echo "Total Videos: $cnt, SUCCESS: $success, FAILED: ".( $cnt - $success )."\n";