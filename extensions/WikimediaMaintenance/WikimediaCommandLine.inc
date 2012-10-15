<?php

// Detect $IP
$IP = getenv( 'MW_INSTALL_PATH' );
if ( $IP === false ) {
	$IP = dirname( __FILE__ ) . '/../..';
}

// Require base maintenance class
require_once( "$IP/maintenance/commandLine.inc" );
