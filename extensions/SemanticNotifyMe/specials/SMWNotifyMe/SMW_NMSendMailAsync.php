<?php
/**
 * Created on 2009/3/25
 *
 * Author: ning
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
	die( -1 );
}

// include commandLine script which provides some basic
// methodes for maintenance scripts
$mediaWikiLocation = dirname( __FILE__ ) . '/../../../..';
require_once "$mediaWikiLocation/maintenance/commandLine.inc";

global $smwgNMIP;
require_once $smwgNMIP . '/includes/SMW_NMStorage.php';
$sStore = NMStorage::getDatabase();
$msgs = $sStore->getUnmailedNMMessages();
foreach ( $msgs as $msg ) {
	// send notifications by mail
	if ( $msg['user_id'] == null ) {
		continue;
	}
	$user_info = $sStore->getUserInfo( $msg['user_id'] );
	$user = User::newFromRow( $user_info );
	if ( ( $user_info->user_email != '' ) &&  $user->getGlobalPreference( 'enotifyme' ) ) {
		$name = ( ( $user_info->user_real_name == '' ) ? $user_info->user_name:$user_info->user_real_name );

		UserMailer::send(
			new MailAddress( $user_info->user_email, $name ),
			new MailAddress( $wgEmergencyContact, 'Admin' ),
			wfMsg( 'smw_nm_hint_mail_title', $msg['title'], $wgSitename ),
			wfMsg( 'smw_nm_hint_mail_body_html', $name, $msg['notify'] ),
			new MailAddress( $wgEmergencyContact, 'Admin' ),
			'text/html; charset=UTF-8'
		);
	}
}
