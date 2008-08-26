<?php

/**
 * Subversion invoker for inetd
 */

if ( php_sapi_name() !== 'cli' ) {
	echo "This script can only be run from the command line\n";
	exit( 1 );
}

$wgExtDistWorkingCopy = '/home/wikipedia/ExtensionDistributor/mw-snapshot';
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
	global $wgExtDistWorkingCopy;

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

	// svn up
	$dir = "$wgExtDistWorkingCopy/$version/extensions/$extension";
	$cmd = "svn up --non-interactive " . escapeshellarg( $dir ) . " 2>&1";
	$retval = -1;
	$result = svnShellExec( $cmd, $retval );
	if ( $retval ) {
		svnError( 'extdist-svn-error', $result );
		return;
	}

	// Determine last changed revision
	$cmd = "svn info --non-interactive --xml " . escapeshellarg( $dir );
	$retval = -1;
	$result = svnShellExec( $cmd, $retval );
	if ( $retval ) {
		svnError( 'extdist-svn-error', $result );
		return;
	}

	try {
		$sx = new SimpleXMLElement( $result );
		$rev = strval( $sx->entry->commit['revision'] );
	} catch ( Exception $e ) {
		$rev = false;
	}
	if ( !$rev || strpos( $rev, '/' ) !== false || strpos( $rev, "\000" ) !== false ) {
		svnError( 'extdist-svn-parse-error', $result );
		return;
	}

	echo json_encode( array( 'revision' => $rev ) );
}
