<?php
/**
 * txt2cdb: Converts the text file of ISO codes to a constant database.
 *
 * Usage: php txt2cdb.php
 */

$dir = dirname( __FILE__ ); $IP = "$dir/../..";
@include( "$dir/../../CorePath.php" ); // Allow override
require_once( "$IP/maintenance/commandLine.inc" );

$names = dirname( __FILE__ ) . '/names.cdb';
$codes = dirname( __FILE__ ) . '/codes.cdb';
$names = CdbWriter::open( $names );
$codes = CdbWriter::open( $codes );

$fr = fopen( dirname( __FILE__ ) . '/codes.txt', 'r' );
while ( $line = fgets( $fr ) ) {
	// Format is code1 code2 "language name"
	$line = explode( ' ', $line, 3 );
	$iso1 = trim( $line[0] );
	$iso3 = trim( $line[1] );
	// Strip quotes
	$name = substr( trim( $line[2] ), 1, -1 );
	if ( $iso1 !== '-' ) {
		$codes->set( $iso1, $iso1 );
		if ( $iso3 !== '-' ) $codes->set( $iso3, $iso1 );
		$names->set( $iso1, $name );
		$names->set( $iso3, $name );
	} elseif ( $iso3 !== '-' ) {
		$codes->set( $iso3, $iso3 );
		$names->set( $iso3, $name );
	}
}
fclose( $fr );
