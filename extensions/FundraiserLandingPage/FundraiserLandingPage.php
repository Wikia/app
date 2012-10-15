<?php

/*
 * Extension:FundraiserLandingPage. This extension takes URL parameters in the
 * QueryString and passes them to the specified template as template variables. 
 *
 * @author Peter Gehres <pgehres@wikimedia.org>
 */

// Alert the user that this is not a valid entry point to MediaWiki if they try to access the special pages file directly.
if ( !defined( 'MEDIAWIKI' ) ) {
	echo <<<EOT
To install the FundraiserLandingPage extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/FundraiserLandingPage/FundraiserLandingPage.php" );
EOT;
	exit( 1 );
}

$wgExtensionCredits[ 'specialpage' ][ ] = array(
	'path' => __FILE__,
	'name' => 'FundraiserLandingPage',
	'author' => array( 'Peter Gehres', 'Ryan Kaldari' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:FundraiserLandingPage',
	'descriptionmsg' => 'fundraiserlandingpage-desc',
	'version' => '1.0.0',
);

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses[ 'FundraiserLandingPage' ] = $dir . 'FundraiserLandingPage.body.php';
$wgAutoloadClasses[ 'FundraiserRedirector' ] = $dir . 'FundraiserRedirector.body.php';

$wgExtensionMessagesFiles[ 'FundraiserLandingPage' ] = $dir . 'FundraiserLandingPage.i18n.php';

$wgSpecialPages[ 'FundraiserLandingPage' ] = 'FundraiserLandingPage';
$wgSpecialPages[ 'FundraiserRedirector' ] = 'FundraiserRedirector';

/*
 * Defaults for the required fields.  These fields will be included whether
 * or not they are passed through the querystring.
 */
$wgFundraiserLPDefaults = array(
	'template' => 'Lp-layout-default',
	'appeal' => 'Appeal-default',
	'appeal-template' => 'Appeal-template-default',
	'form-template' => 'Form-template-default',
	'form-countryspecific' => 'Form-countryspecific-control',
	'country' => 'XX' // per Charles Barr
);

// Adding configurrable variable for caching time
$wgFundraiserLandingPageMaxAge = 300; //5 minutes

