<?php
/**
 * FundraiserPortal extension
 *
 * @file
 * @ingroup Extensions
 *
 * This file contains the main include file for the FundraiserPortal
 * extension of MediaWiki.
 *
 * Usage: Add the following line to your LocalSettings.php file
 * require_once( "$IP/extensions/FundraiserPortal/FundraiserPortal.php" );
 *
 * @author Trevor Parscal <tparscal@wikimedia.org>
 * Allow "or a later version" here?
 * @license GPL v2
 * @version 0.1.1
 */

/* Configuration */

// on/off Switch
$wgFundraiserPortalShow = true;

// Set this to the base target of any button 
$wgFundraiserPortalURL = 'http://wikimediafoundation.org/wiki/Donate/Now/en?utm_medium=sidebar&utm_campaign=spontaneous_donation';

// Set this to the location the extensions images
$wgFundraiserImageUrl = $wgScriptPath . '/extensions/FundraiserPortal/images';

// Allowable templates: Plain, Ruby, RubyText, Sapphire, Tourmaline
$wgFundraiserPortalTemplates = array( 
				'Ruby' => 25,
				'Tourmaline' => 25,
				'RubyText' => 25,
				'Sapphire' => 25,
				);

// Set this to the public path where your js is pulled from
$wgFundraiserPortalPath = '';

// Set this to the systme path location that the button js file will be written to
// Must be reachable by the address in $wgNoticeProjectPath
$wgFundraiserPortalDirectory = '';

// Only running this on wikipedia for now
$wgFundraiserPortalProject = 'wikipedia';

/* Setup */

// Sets Credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'FundraiserPortal',
	'author' => 'Trevor Parscal, Tomasz Finc',
	'version' => '0.2.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:FundraiserPortal',
	'descriptionmsg' => 'fundraiserportal-desc',
);


// Load some classes
$wgAutoloadClasses['DonateButton'] = dirname( __FILE__ ) . '/' . 'DonateButton.php';

// Adds Internationalized Messages
$wgExtensionMessagesFiles['FundraiserPortal'] =
	dirname( __FILE__ ) . "/FundraiserPortal.i18n.php";

$wgHooks['BeforePageDisplay'][] = 'efFundraiserPortalLoader';

// Load the js that will choose the button client side
function efFundraiserPortalLoader( $out, $skin ) {
	global $wgOut, $wgContLang;
	global $wgFundraiserPortalShow, $wgFundraiserPortalProject, $wgFundraiserPortalPath;
	
	// Only proceed if we are configured to show the portal
	if ( !$wgFundraiserPortalShow ) {
		return true;
	}

	// Pull in our loader
	$lang = $wgContLang->getCode(); // note: this is English-only for now
	$fundraiserLoader = "$wgFundraiserPortalProject/$lang/fundraiserportal.js";
	$encFundraiserLoader = Xml::encodeJsVar( "$wgFundraiserPortalPath/$fundraiserLoader" );
	$wgOut->addInlineScript(
		"var wgFundraiserPortal='', wgFundraiserPortalCSS='';\n" .
		"mediaWiki.loader.load($encFundraiserLoader);\n"
	);

	return true;
}
