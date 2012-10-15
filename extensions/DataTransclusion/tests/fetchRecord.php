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

$src = $args[0];
$field = $args[1];
$value = $args[2];

$source = DataTransclusionHandler::getDataSource( $src );
$data = $source->fetchRecord( $field, $value, null );

print_r( $data );