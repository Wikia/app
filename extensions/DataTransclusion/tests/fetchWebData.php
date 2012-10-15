<?php
if ( isset( $GET_ ) ) {
	echo( "This file cannot be run from the web.\n" );
	die( 1 );
}

if ( getenv( 'MW_INSTALL_PATH' ) ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$dir = dirname( __FILE__ );

	if ( file_exists( "$dir/../../LocalSettings.php" ) ) $IP = "$dir/../..";
	elseif ( file_exists( "$dir/../../../LocalSettings.php" ) ) $IP = "$dir/../../..";
	elseif ( file_exists( "$dir/../../phase3/LocalSettings.php" ) ) $IP = "$dir/../../phase3";
	elseif ( file_exists( "$dir/../../../phase3/LocalSettings.php" ) ) $IP = "$dir/../../../phase3";
	else $IP = $dir;
}

require_once( "$IP/maintenance/commandLine.inc" );

$dir = dirname( __FILE__ );
$dtbase = dirname( realpath( $dir ) );

require_once( "$dtbase/DataTransclusionSource.php" );
require_once( "$dtbase/WebDataTransclusionSource.php" );

$url = $args[0];
$format = $args[1];

$spec = array(
	'name' => 'Dummy',
	'keyFields' => 'id',
	'url' => 'http://test.com/',
	'dataFormat' => $format,
);

$web = new WebDataTransclusionSource( $spec );
$raw = $web->loadRecordDataFromURL( $url );
if (!$raw) die("failed to load data from $url\n");

$data = $web->decodeData( $raw, $format );
if (!$data) die("failed to decode($format) data from $url\n");

print_r( $data );