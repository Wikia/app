<?php

# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install PayflowPro Gateway extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/payflowpro_gateway/payflowpro_gateway.php" );
EOT;
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'PayflowPro Gateway',
	'author' => 'Four Kitchens',
	'version' => '1.0.0',
	'description' => 'Integrates Paypal Payflow Pro credit card processing',
	'descriptionmsg' => 'payflowpro_gateway-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:PayflowProGateway',
);

// Set up the new special page
$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['PayflowProGateway'] = $dir . 'payflowpro_gateway.body.php';
$wgExtensionMessagesFiles['PayflowProGateway'] = $dir . 'payflowpro_gateway.i18n.php';
$wgExtensionAliasesFiles['PayflowProGateway'] = $dir . 'payflowpro_gateway.alias.php';
$wgSpecialPages['PayflowProGateway'] = 'PayflowProGateway';

// set defaults, these should be assigned in LocalSettings.php
$wgPayflowProURL = 'https://payflowpro.paypal.com';
$wgPayflowProTestingURL = 'https://pilot-payflowpro.paypal.com'; // Payflow testing URL

$wgPayFlowProGatewayCSSVersion = 1;

$wgPayflowProPartnerID = ''; //PayPal or original authorized reseller
$wgPayflowProVendorID = ''; // paypal merchant login ID
$wgPayflowProUserID = ''; //if one or more users are set up, authorized user ID, else same as VENDOR
$wgPayflowProPassword = ''; //merchant login password

$wgPayflowGatewayDBserver = $wgDBserver;
$wgPayflowGatewayDBname = $wgDBname;
$wgPayflowGatewayDBuser = $wgDBuser;
$wgPayflowGatewayDBpassword = $wgDBpassword;

function payflowGatewayConnection() {
	global $wgPayflowGatewayDBserver, $wgPayflowGatewayDBname;
	global $wgPayflowGatewayDBuser, $wgPayflowGatewayDBpassword;

	static $db;

	if ( !$db ) {
		$db = new DatabaseMysql(
			$wgPayflowGatewayDBserver,
			$wgPayflowGatewayDBuser,
			$wgPayflowGatewayDBpassword,
			$wgPayflowGatewayDBname );
			$db->query( "SET names utf8" );
	}

	return $db;
}

/** 
 * Hooks required to interface with the donation extension (include <donate> on page)
 *
 * gwValue supplies the value of the form option, the name that appears on the form
 * and the currencies supported by the gateway in the $values array
 */
$wgHooks['DonationInterface_Value'][] = 'pfpGatewayValue';
$wgHooks['DonationInterface_Page'][] = 'pfpGatewayPage';

/**
 * Hook to register form value and display name of this gateway
 * also supplies currencies supported by this gateway
 */
function pfpGatewayValue( &$values ) {

	$values['payflow'] = array(
		'gateway' => 'payflow',
		'display_name' => 'Credit Card',
		'form_value' => 'payflow',
		'currencies' => array(
			'GBP' => 'GBP: British Pound',
			'EUR' => 'EUR: Euro',
			'USD' => 'USD: U.S. Dollar',
			'AUD' => 'AUD: Australian Dollar',
			'CAD' => 'CAD: Canadian Dollar',
			'JPY' => 'JPY: Japanese Yen',
		),
	);

	return true;
}

/**
 *  Hook to supply the page address of the payment gateway
 *
 * The user will redirected here with supplied data with input data appended (GET).
 * For example, if $url[$key] = index.php?title=Special:PayflowPro
 * the result might look like this: http://www.yourdomain.com/index.php?title=Special:PayflowPro&amount=75.00&currency_code=USD&payment_method=payflow
 */
function pfpGatewayPage( &$url ) {
	global $wgScript;

	//$url['payflow'] = 'https://payments.wikimedia.org/index.php' . '?title=Special:PayflowProGateway';
	//$url['payflow'] = 'http://c2p2.fkbuild.com/index.php?title=Special:PayflowProGateway';
	$url['payflow'] = $wgScript . "?title=Special:PayflowProGateway";
	return true;
}
