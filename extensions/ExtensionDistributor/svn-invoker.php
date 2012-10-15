<?php

/**
 * Subversion invoker for inetd
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

svnExecute();

function svnValidate( $s ) {
	if ( strpos( $s, '..' ) !== false ) {
		return false;
	}
	return true;
}

function svnShellExec( $cmd, &$retval ) {
	$retval = 1; // error by default?
	ob_start();
	passthru( $cmd, $retval );
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
}

function svnError( $msg, $info = false ) {
	echo json_encode( array( 'error' => $msg, 'errorInfo' => $info ) );
}

function svnExecute() {
	global $wgExtDistWorkingCopy, $wgExtDistLockFile;

	$encCommand = '';
	$done = false;
	while ( !$done && STDIN && !feof( STDIN ) ) {
		$buf = fread( STDIN, 8192 );
		$nullPos = strpos( $buf, "\000" );
		if ( $nullPos !== false ) {
			$buf = substr( $buf, 0, $nullPos );
			$done = true;
		}
		$encCommand .= $buf;
	}
	if ( !$encCommand ) {
		svnError( 'extdist-remote-error', "Invalid command." );
		return;
	}

	if ( $wgExtDistLockFile ) {
		$lockFile = fopen( $wgExtDistLockFile, 'a' );
		if ( !$lockFile ) {
			svnError( 'extdist-remote-error', "Unable to open lock file." );
			return;
		}
		$timeout = 3;
		for ( $i = 0; $i < $timeout; $i++ ) {
			$wouldBlock = false;
			if ( flock( $lockFile, LOCK_EX | LOCK_NB ) ) {
				break;
			}
			sleep( 1 );
		}
		if ( $i == $timeout ) {
			svnError( 'extdist-remote-error', "Lock wait timeout." );
			return;
		}
	}

	$command = json_decode( $encCommand );
	if ( !isset( $command->version ) || !isset( $command->extension ) ) {
		svnError( 'extdist-remote-error', "Missing version or extension parameter." );
		return;
	}
	if ( !svnValidate( $command->version ) ) {
		svnError( 'extdist-remote-error', "Invalid version parameter" );
		return;
	} elseif ( !svnValidate( $command->extension ) ) {
		svnError( 'extdist-remote-error', "Invalid extension parameter" );
		return;
	}
	$version = $command->version;
	$extension = $command->extension;
	$dir = "$wgExtDistWorkingCopy/$version/extensions/$extension";

	// Determine last changed revision in the checkout
	$localRev = svnGetRev( $dir, $remoteDir );
	if ( !$localRev ) {
		return;
	}
		
	// Determine last changed revision in the repo
	$remoteRev = svnGetRev( $remoteDir );
	if ( !$remoteRev ) {
		return;
	}
	
	if ( $remoteRev != $localRev ) {
		// Bad luck, we need to svn up
		$cmd = "svn up --non-interactive " . escapeshellarg( $dir ) . " 2>&1";
		$retval = - 1;
		$result = svnShellExec( $cmd, $retval );
		if ( $retval ) {
			svnError( 'extdist-svn-error', $result );
			return;
		}
	}
	
	echo json_encode( array( 'revision' => $remoteRev ) );
}

// Returns the last changed revision or false
// @param $dir Path or url of the folder
// Output param $url Remote location of the folder
function svnGetRev( $dir, &$url = null ) {
	
	$cmd = "svn info --non-interactive --xml " . escapeshellarg( $dir );
	$retval = - 1;
	$result = svnShellExec( $cmd, $retval );
	if ( $retval ) {
		svnError( 'extdist-svn-error', $result );
		return false;
	}

	try {
		$sx = new SimpleXMLElement( $result );
		$rev = strval( $sx->entry->commit['revision'] );
		$url = $sx->entry->url;
	} catch ( Exception $e ) {
		$rev = false;
	}
	if ( !$rev || strpos( $rev, '/' ) !== false || strpos( $rev, "\000" ) !== false ) {
		svnError( 'extdist-svn-parse-error', $result );
		return false;
	}
	
	return $rev;
}
