<?php

/**
 * Maintenance script to move a batch of pages
 *
 * @file
 * @ingroup Maintenance
 *
 * USAGE: php moveOn.php [-u <user>] [-r <reason>] [--ot <old title>] [--on <old title namespace>] [--nt <new title>] [--nn <new title namespace>] [--redirect 1] [--watch 1]
 *  -movetalk - move talk page if possible
 *  -movesub  - move subpages
 *  -redirect - leave a redirect behind
 *  -watch - add page to the watchlist
 */

$oldCwd = getcwd();
$optionsWithArgs = array( 'u', 'ot', 'on', 'nt', 'nn', 'redirect', 'watch', 'r' );
ini_set( "include_path", dirname(__FILE__)."/.." );
require_once( 'commandLine.inc' );

chdir( $oldCwd );

# Options processing

$filename = 'php://stdin';
$user = 'Move page script';
$oldtitle = $newtitle = $reason = '';
$oldnamespace = $newnamespace = 0;
$redirect = $watch = false;
$interval = 0;

#echo print_r($options, true);

if ( isset( $options['u'] ) )  $user = $options['u'];
if ( isset( $options['r'] ) )  $reason = $options['r'];
if ( isset( $options['ot'] ) ) $oldtitle = $options['ot'];
if ( isset( $options['on'] ) ) $oldnamespace = $options['on'];
if ( isset( $options['nt'] ) ) $newtitle = $options['nt'];
if ( isset( $options['nn'] ) ) $newnamespace = $options['nn'];
if ( isset( $options['redirect'] ) ) $redirect = true;
if ( isset( $options['watch'] ) )    $watch = true;

$wgUser = User::newFromName( $user );

# Setup complete, now start

$file = fopen( $filename, 'r' );
if ( !$file ) {
	print "Unable to read file, exiting\n";
	exit(1);
}

$dbw = wfGetDB( DB_MASTER );

# check titles
$oOldTitle = Title::newFromText( $oldtitle, $oldnamespace );
$oNewTitle = Title::newFromText( $newtitle, $newnamespace );
if ( is_null( $oOldTitle ) ) {
	print "Invalid old title for: " . $oldtitle . " ns: " . $oldnamespace . " \n";
	exit(1);
}

if ( is_null( $oNewTitle ) ) {
	print "Invalid new title for: " . $newtitle . " ns: " . $newnamespace . " \n";
	exit(1);
}

# Check user rights
/*$permErrors = $oOldTitle->getUserPermissionsErrors( 'move', $wgUser );
if ( !empty( $permErrors ) ) {
	print "User " . $wgUser->getName() . " doesn't have permission for move page: " . ( is_array($permErrors) ? implode(", ", $permErrors) : $permErrors ). "\n";
	exit(1);
}*/

if ( $wgUser->isAllowed( 'suppressredirect' ) ) {
	$createRedirect = $redirect;
} else {
	$createRedirect = true;
}

print "move: " . $oOldTitle->getPrefixedText() . " to " . $oNewTitle->getPrefixedText() . " \n";

$dbw->begin();

$err = $oOldTitle->moveTo( $oNewTitle, false, $reason, $createRedirect );
if ( $err !== true ) {
	$dbw->rollback();
	$msg = array_shift( $err[0] );
	print "\nMove failed: " . wfMsg( $msg, $err[0] );
	exit(1);
}

$dbw->immediateCommit();

print "Add/remove watching \n";

if( $watch ) {
	$wgUser->addWatch( $oOldTitle );
	$wgUser->addWatch( $oNewTitle );
} else {
	$wgUser->removeWatch( $oOldTitle );
	$wgUser->removeWatch( $oNewTitle );
}

print "\nDone\n\n";




