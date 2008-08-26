<?php

require_once 'commandLine.inc';

if( count( $argv ) == 0 ) {
	echo "Available actions: status, check <ip>\n";
	exit( 0 );
}

function errorOrValue( $val ) {
	if( WikiError::isError( $val ) ) {
		die( $val->toString() . "\n" );
	}
	return $val;
}

function showStatus() {
	$ret = errorOrValue( MWBlocker::getStatus() );
	echo $ret . "\n";
}

switch( $argv[count($argv)-1] ) {
case "status":
	showStatus();
	break;
case "check":
	errorOrValue( MWBlocker::queueCheck( $argv[1], "command-line check" ) );
	showStatus();
	break;
default:
	echo "Unrecognized verb.\n";
	exit( -1 );
}


