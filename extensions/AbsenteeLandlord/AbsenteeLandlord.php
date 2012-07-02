<?php
/** \file
* \brief Contains code for the AbsenteeLandlord extension by Ryan Schmidt and Tim Laqua.
*/

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone\n" );
	die( 1 );
}

$wgAbsenteeLandlordMaxDays = 90; // how many days do the sysops have to be inactive for?

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Absentee Landlord',
	'author' => array( 'Ryan Schmidt', 'Tim Laqua' ),
	'version' => '1.1',
	'descriptionmsg' => 'absenteelandlord-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:AbsenteeLandlord',
);

$wgExtensionFunctions[] = 'efAbsenteeLandlord_Setup';
$wgHooks['BeforePageDisplay'][] = 'efAbsenteeLandlord_MaybeDoTouch';

$wgExtensionMessagesFiles['AbsenteeLandlord'] =  dirname( __FILE__ ) . '/AbsenteeLandlord.i18n.php';

function efAbsenteeLandlord_Setup() {
	global $wgAbsenteeLandlordMaxDays;

	$timeout = $wgAbsenteeLandlordMaxDays * 24 * 60 * 60; // # days * 24 hours * 60 minutes * 60 seconds
	$lasttouched = filemtime( dirname( __FILE__ ) . '/lasttouched.txt' );
	$check = time() - $lasttouched;

	if ( $check >= $timeout ) {
		global $wgUser;
		$groups = $wgUser->getGroups();

		if ( !in_array( 'sysop', $groups ) ) {
			global $wgReadOnly;

			# Add Messages (don't need them unless we get here)
			
			$wgReadOnly = wfMsg( 'absenteelandlord-reason' );
		}
	}

	return true;
}

function efAbsenteeLandlord_MaybeDoTouch( &$out, $sk = null ) {
	global $wgUser;
	$groups = $wgUser->getGroups();
	if ( in_array( 'sysop', $groups ) ) {
		touch( dirname( __FILE__ ) . '/lasttouched.txt' );
	}
	return true;
}
