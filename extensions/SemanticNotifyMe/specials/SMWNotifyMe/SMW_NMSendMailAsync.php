<?php
/*
 * Created on 2009/3/25
 *
 * Author: Dch
 */

// get Parameter
$wgRequestTime = microtime( true );

/** */
# Abort if called from a web server
if ( isset( $_SERVER ) && array_key_exists( 'REQUEST_METHOD', $_SERVER ) ) {
	print "This script must be run from the command line\n";
	exit();
}

if ( version_compare( PHP_VERSION, '5.0.0' ) < 0 ) {
	print "Sorry! This version of MediaWiki requires PHP 5; you are running " .
	PHP_VERSION . ".\n\n" .
		"If you are sure you already have PHP 5 installed, it may be " .
		"installed\n" .
		"in a different path from PHP 4. Check with your system administrator.\n";
	die( - 1 );
}

// copy from user class
function getUserNMOption( $str ) {
	$options = array();
	$a = explode( "\n", $str );
	foreach ( $a as $s ) {
		$m = array();
		if ( preg_match( "/^(.[^=]*)=(.*)$/", $s, $m ) ) {
			$options[$m[1]] = $m[2];
		}
	}
	return $options['enotifyme'];
}

// include commandLine script which provides some basic
// methodes for maintenance scripts
$mediaWikiLocation = dirname( __FILE__ ) . '/../../../..';
require_once "$mediaWikiLocation/maintenance/commandLine.inc";

$sStore = smwfGetSemanticStore();
$msgs = $sStore->getUnmailedNMMessages();
foreach ( $msgs as $msg ) {
	// send notifications by mail
	$user_info = $sStore->getUserInfo( $msg['user_id'] );
	if ( ( $user_info->user_email != '' ) && getUserNMOption( $user_info->user_options ) ) {
		$name = ( ( $user_info->user_real_name == '' ) ? $user_info->user_name:$user_info->user_real_name );
		$body = "Dear Mr./Mrs. $name,<br/>" . $msg['notify'] .
				"<br/><br/>Sincerely yours,<br/>SMW NotifyMe Bot";

		UserMailer::send( // userMailer(
			new MailAddress( $user_info->user_email, $name ),
			new MailAddress( $wgEmergencyContact, 'Admin' ),
			'New SMW Notification comes, from ' . $wgSitename,
			$body,
			new MailAddress( $wgEmergencyContact, 'Admin' ),
			true
		);
	}
}
