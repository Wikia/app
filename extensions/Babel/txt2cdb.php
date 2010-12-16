<?php

/**
 * txt2cdb: Converts the text file of ISO codes to a constant database.
 */

$dir = dirname( __FILE__ ); $IP = "$dir/../..";
@include("$dir/../../CorePath.php"); // Allow override
require_once( "$IP/maintenance/commandLine.inc" );

// Names

$names = dirname( __FILE__ ) . '/names.cdb';
$codes = dirname( __FILE__ ) . '/codes.cdb';
$names = CdbWriter::open( $names );
$codes = CdbWriter::open( $codes );

$fp = fopen( dirname( __FILE__ ) . '/codes.txt', 'r' );
while( $line = fgets( $fp ) ) {
	$line = explode( ' ', $line );
	$iso1 = trim( $line[ 0 ] );
	$iso3 = trim( $line[ 1 ] );
	$name = substr( trim( $line[ 2 ] ), 1, -1 );
	if( $iso1 !== '-' ) {
		$codes->set( $iso1, $iso1 );
		if( $iso3 !== '-' ) $codes->set( $iso3, $iso1 );
		$names->set( $iso1, $name );
		$names->set( $iso3, $name );
	} elseif( $iso3 !== '-' ) {
		$codes->set( $iso3, $iso3 );
		$names->set( $iso3, $name );
	}
}
fclose( $fp );
