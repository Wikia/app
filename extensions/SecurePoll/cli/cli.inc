<?php

$IP = getenv( 'MW_INSTALL_PATH' );
if ( strval( $IP ) === '' ) {
	$IP = dirname( __FILE__ ).'/../../..';
}
if ( !file_exists( "$IP/includes/WebStart.php" ) ) {
	$IP .= '/phase3';
}
if ( !file_exists( "$IP/includes/WebStart.php" ) ) {
	echo "Can't find your MediaWiki installation. Please set the MW_INSTALL_PATH environment variable.\n";
	exit( 1 );
}

require( $IP . '/maintenance/commandLine.inc' );
