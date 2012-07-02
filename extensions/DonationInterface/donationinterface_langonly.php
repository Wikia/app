<?php 
/**
 * Donation Interface - Lang only
 * 
 * When installed, this will *ONLY* load i18n messages from DonationInterface. This
 * will not expose any other DonationInterface functionality.
 * 
 * To install the DontaionInterface extension, put the following line in LocalSettings.php:
 * require_once( "\$IP/extensions/DonationInterface/donationinterface_langonly.php" );
 *
 */

# Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install the DontaionInterface lang only extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/DonationInterface/donationinterface_langonly.php" );
EOT;
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Donation Interface - Language Only',
	'author' => array( 'Katie Horn', 'Ryan Kaldari' , 'Arthur Richards', 'Jeremy Postlethwaite' ),
	'version' => '2.0.0',
	'descriptionmsg' => 'donate_interface-langonly-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:DonationInterface',
);

$donationinterface_dir = dirname( __FILE__ ) . '/';

// Load the interface messages that are shared across all gateways
$wgExtensionMessagesFiles['DonateInterface'] = $donationinterface_dir . 'gateway_common/interface.i18n.php';
$wgExtensionMessagesFiles['GatewayCountries'] = $donationinterface_dir . 'gateway_common/countries.i18n.php';
$wgExtensionMessagesFiles['GatewayUSStates'] = $donationinterface_dir . 'gateway_common/us-states.i18n.php';
$wgExtensionMessagesFiles['GatewayCAProvinces'] = $donationinterface_dir . 'gateway_common/canada-provinces.i18n.php';

// PayflowPro-specific messaging
$wgExtensionMessagesFiles['PayflowProGateway'] = $donationinterface_dir . 'payflowpro_gateway/payflowpro_gateway.i18n.php';
$wgExtensionMessagesFiles['PayflowProGatewayAlias'] = $donationinterface_dir . 'payflowpro_gateway/payflowpro_gateway.alias.php';

// GlobalCollect-specific messaging
$wgExtensionMessagesFiles['GlobalCollectGateway'] = $donationinterface_dir . 'globalcollect_gateway/globalcollect_gateway.i18n.php';
$wgExtensionMessagesFiles['GlobalCollectGatewayAlias'] = $donationinterface_dir . 'globalcollect_gateway/globalcollect_gateway.alias.php';