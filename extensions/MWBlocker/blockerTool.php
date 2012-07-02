<?php

require_once 'commandLine.inc';

if( count( $argv ) == 0 ) {
	echo "Available actions: status, check <ip>\n";
	exit( 0 );
}

function showStatus() {
	try {
		$ret = MWBlocker::getStatus();
		echo $ret . "\n";
	} catch( MWEexception $e ) {
		die( $e->getMessage() . "\n" );
	}
}

switch( $argv[count($argv)-1] ) {
case "status":
	showStatus();
	break;
case "check":
	try {
		MWBlocker::queueCheck( $argv[1], "command-line check" );
	} catch( MWEexception $e ) {
		die( $e->getMessage() . "\n" );
	}
	showStatus();
	break;
default:
	echo "Unrecognized verb.\n";
	exit( -1 );
}


