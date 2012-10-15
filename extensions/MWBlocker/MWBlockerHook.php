<?php

require_once( 'MWBlocker.php' );

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'BlockerHook',
	'author'         => '',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:BlockerHook',
);

$wgExtensionFunctions[] = 'mwBlockerHookSetup';

function mwBlockerHookSetup() {
	global $wgHooks;
	// create account
	$wgHooks['AddNewAccount'][] = 'mwBlockerCheck';
}

function mwBlockerCheck() {
	global $wgDBname;
	$ip = wfGetIP();
	try {
		MWBlocker::queueCheck( $ip, "creating account on $wgDBname" );
	} catch( MWException $e ) {}
	return true;
}


