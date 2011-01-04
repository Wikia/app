<?php

// Trick MW into thinking this is a command line script.
// This is obviously not a good approach, as it will not work on other setups then my own.
unset( $_SERVER['REQUEST_METHOD'] );
$argv = array( 'over9000failz' );
$optionsWithArgs = array();
if ( count( $_REQUEST ) ) {
	die( "This is a pseudo-command line script" );
}

if ( getenv( 'MW_INSTALL_PATH' ) !== false ) {
	$IP = getenv( 'MW_INSTALL_PATH' );
} else {
	$IP = false;
	foreach( array( '../../../phase3', '../../../smw', '../..' ) as $rel ) {
		if ( file_exists( dirname( __FILE__ ) . "/$rel/maintenance/commandLine.inc" ) ) {
			$IP = dirname( __FILE__ ) . "/$rel";
			break;
		}
	}
	if ( !$IP ) {
		die( 'maintenance/commandLine.inc not found' );
	}
}
require( "$IP/maintenance/commandLine.inc" );

