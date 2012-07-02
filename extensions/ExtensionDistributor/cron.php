<?php

/**
 * Script to be run from cron, to update the svn working copies (especially new extensions)
 */

if ( php_sapi_name() !== 'cli' ) {
	echo "This script can only be run from the command line\n";
	exit( 1 );
}

$wgExtDistWorkingCopy = false;
$wgExtDistLockFile = false;
$confFile = dirname( __FILE__ ) . '/svn-invoker.conf';
if ( !file_exists( $confFile ) ) {
	echo "Error: please create svn-invoker.conf based on svn-invoker.conf.sample\n";
	exit( 1 );
}
require( $confFile );

cronExecute();

function cronExecute() {
	global $wgExtDistWorkingCopy, $wgExtDistLockFile;
	if ( $wgExtDistLockFile ) {
		$lockFile = fopen( $wgExtDistLockFile, 'a' );
		if ( !$lockFile ) {
			echo "Error opening lock file\n";
			exit( 1 );
		}
		if ( !flock( $lockFile, LOCK_EX | LOCK_NB ) ) {
			echo "Error obtaining lock\n";
			exit( 1 );
		}
	}

	// Update the files
	svnUpdate( "$wgExtDistWorkingCopy/trunk/extensions" );
	foreach ( glob( "$wgExtDistWorkingCopy/branches/*", GLOB_ONLYDIR ) as $branch ) {
		svnUpdate( "$branch/extensions" );
	}
}

function svnUpdate( $path ) {
	$cmd = "svn up --non-interactive " . escapeshellarg( $path );
	$retval = 1;
	system( $cmd, $retval );
	if ( $retval ) {
		echo "Error executing command: $cmd\n";
		exit( 1 );
	}
}
