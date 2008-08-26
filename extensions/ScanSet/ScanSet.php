<?php
/**
 * To enable this extension, put the following at the bottom of your LocalSettings.php:
 *    require_once( "$IP/extensions/ScanSet/ScanSet.php" );
 *
 * And optionally, after that, something like:
 *    $wgScanSetSettings = array(
 *        'baseDirectory'   => '/local/path/to/images',
 *        'basePath'        => '/url/path/to/images',
 *    );
 */

if ( !defined( 'MEDIAWIKI' ) ) die( 'Not a valid entry point.' );

$wgExtensionCredits['other'][] = array(
	'name' => 'ScanSet',
	'url' => 'http://www.mediawiki.org/wiki/Extension:ScanSet',
	'description' => 'View scanned page images from Andreas Grosz\'s CD/DVD sets',
	'descriptionmsg' => 'scanset-desc',
	'author' => 'Tim Starling',
);

$wgExtensionMessagesFiles['ScanSet'] = dirname(__FILE__) . '/ScanSet.i18n.php';
$wgExtensionFunctions[] = 'wfScanSetSetup';
$wgScanSetSettings = array();

function wfScanSetSetup() {
	global $wgParser;
	$wgParser->setHook( 'scanset', 'wfScanSetHook' );
}

function wfScanSetHook( $content, $params, &$parser ) {
	global $wgScanSetSettings;

	require_once( dirname( __FILE__ ) . '/ScanSet_body.php');
	$ss = new ScanSet( $params, $parser, $wgScanSetSettings );
	return $ss->execute();
}
