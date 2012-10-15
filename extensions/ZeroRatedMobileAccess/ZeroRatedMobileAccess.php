<?php
/**
 * Extension ZeroRatedMobileAccess — Zero Rated Mobile Access
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

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path'  =>  __FILE__,
	'name'  =>  'ZeroRatedMobileAccess',
	'version'  =>  '0.0.1',
	'author' => array( 'Patrick Reilly' ),
	'descriptionmsg'  =>  'zero-rated-mobile-access-desc',
	'url'  =>  'https://www.mediawiki.org/wiki/Extension:ZeroRatedMobileAccess',
);

$cwd = dirname( __FILE__ ) . DIRECTORY_SEPARATOR;
$wgExtensionMessagesFiles['ZeroRatedMobileAccess'] = $cwd . 'ZeroRatedMobileAccess.i18n.php';

// autoload extension classes

$autoloadClasses = array (
	'ZeroRatedMobileAccessTemplate' => 'ZeroRatedMobileAccessTemplate',
	'ExtZeroRatedMobileAccess' => 'ZeroRatedMobileAccess.body',
);

foreach ( $autoloadClasses as $className => $classFilename ) {
	$wgAutoloadClasses[$className] = $cwd . $classFilename . '.php';
}

$wgEnableZeroRatedMobileAccessTesting = false;

$wgExtZeroRatedMobileAccess = new ExtZeroRatedMobileAccess();

$wgHooks['BeforePageDisplay'][] = array( &$wgExtZeroRatedMobileAccess, 'beforePageDisplayHTML' );