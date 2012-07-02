<?php

/**
 * Validates a transaction against MaxMind's minFraud service
 *
 * For more details on minFraud, go: http://www.maxmind.com/app/minfraud
 *
 *  To install the DontaionInterface extension, put the following line in LocalSettings.php:
 *	require_once( "\$IP/extensions/DonationInterface/donationinterface.php" );
 *  
 * TODO: Outline required globals to include this bad boy! 
 * 
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This file is part of the MinFraud for Gateway extension. It is not a valid entry point.\n" );
}

$wgExtensionCredits['gateway_extras_minfraud'][] = array(
	'name' => 'minfraud',
	'author' => 'Arthur Richards',
	'url' => '',
	'description' => 'This extension uses the MaxMind minFraud service as a validator for the gateway.'
);

function efMinFraudSetup() {
	// if we're in standalone mode, use the GatewayValidate hook
	global $wgHooks;
	$wgHooks["GatewayValidate"][] = array( 'Gateway_Extras_MinFraud::onValidate' );
}
