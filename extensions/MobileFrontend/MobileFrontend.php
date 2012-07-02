<?php
/**
 * Extension MobileFrontend — Mobile Frontend
 *
 * @file
 * @ingroup Extensions
 * @author Patrick Reilly
 * @copyright © 2011 Patrick Reilly
 * @licence GNU General Public Licence 2.0 or later
 */

// Needs to be called within MediaWiki; not standalone
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
	die( -1 );
}

// Define the extension; allows us make sure the extension is used correctly
define( 'MOBILEFRONTEND', 'MobileFrontend' );
// WURFL installation dir
define( 'WURFL_DIR', dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'library' .
		DIRECTORY_SEPARATOR . 'WURFL' . DIRECTORY_SEPARATOR );
// WURFL configuration files directory
define( 'RESOURCES_DIR', dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'library' .
		DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR );

require_once( WURFL_DIR . 'Application.php' );

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'MobileFrontend',
	'version' => '0.7.0',
	'author' => '[http://www.mediawiki.org/wiki/User:Preilly Preilly]',
	'descriptionmsg' => 'mobile-frontend-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:MobileFrontend',
);

$cwd = dirname( __FILE__ ) . DIRECTORY_SEPARATOR;
$wgExtensionMessagesFiles['MobileFrontend'] = $cwd . 'MobileFrontend.i18n.php';

// autoload extension classes

$autoloadClasses = array (
	'ExtMobileFrontend' => 'MobileFrontend.body',
	'DeviceDetection' => 'DeviceDetection',
	'CssDetection' => 'CssDetection',
	'MobileFrontendTemplate' => 'MobileFrontendTemplate',
	'ApplicationTemplate' => 'ApplicationTemplate',
	'SearchTemplate'  => 'SearchTemplate',
	'FooterTemplate' => 'FooterTemplate',
	'LeaveFeedbackTemplate' => 'LeaveFeedbackTemplate',
	'DisableTemplate' => 'DisableTemplate',
	'OptInTemplate' => 'OptInTemplate',
	'OptOutTemplate' => 'OptOutTemplate',
	'ApplicationWmlTemplate' => 'ApplicationWmlTemplate',
	'ThanksNoticeTemplate' => 'ThanksNoticeTemplate',
	'SopaNoticeTemplate' => 'SopaNoticeTemplate',
);

foreach ( $autoloadClasses as $className => $classFilename ) {
	$wgAutoloadClasses[$className] = $cwd . $classFilename . '.php';
}

/**
 * Path to the logo used in the mobile view
 *
 * Should be 22px tall at most
 */
$wgMobileFrontendLogo = false;

$wgMobileDomain = '.m.';

/**
 * URL for script used to disable mobile site
 * (protocol, host, optional port; path portion)
 *
 * e.g., http://en.wikipedia.org/w/mobileRedirect.php
 */
$wgMobileRedirectFormAction = false;

$wgExtMobileFrontend = null;

$wgExtensionFunctions[] = 'efMobileFrontend_Setup';

function efMobileFrontend_Setup() {
	global $wgExtMobileFrontend, $wgHooks;
	$wgExtMobileFrontend = new ExtMobileFrontend();
	$wgHooks['BeforePageDisplay'][] = array( &$wgExtMobileFrontend, 'beforePageDisplayHTML' );
	$wgHooks['BeforePageRedirect'][] = array( &$wgExtMobileFrontend, 'beforePageRedirect' );
	$wgHooks['SkinTemplateOutputPageBeforeExec'][] = array( &$wgExtMobileFrontend, 'addMobileFooter' );
	$wgHooks['TestCanonicalRedirect'][] = array( &$wgExtMobileFrontend, 'testCanonicalRedirect' );
}

/**
 * Make the classes, tags and ids stripped from page content configurable.
 * Each item will be stripped from the page.
 * See $itemsToRemove for more information.
 */
$wgMFRemovableClasses = array();
/**
 * Make the logos configurable.
 * Key for site.
 * Key for logo.
 * Example: array('site' => 'mysite', 'logo' => 'mysite_logo.png');
 */
$wgMFCustomLogos = array( array() );

// Unit tests
$wgHooks['UnitTestsList'][] = 'efExtMobileFrontendUnitTests';

/**
 * @param $files array
 * @return bool
 */
function efExtMobileFrontendUnitTests( &$files ) {
	$files[] = dirname( __FILE__ ) . '/tests/MobileFrontendTest.php';
	$files[] = dirname( __FILE__ ) . '/tests/DeviceDetectionTest.php';
	return true;
}
