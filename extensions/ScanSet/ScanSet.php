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
	'path' => __FILE__,
	'name' => 'ScanSet',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ScanSet',
	'descriptionmsg' => 'scanset-desc',
	'author' => 'Tim Starling',
);

$wgExtensionMessagesFiles['ScanSet'] = dirname(__FILE__) . '/ScanSet.i18n.php';
$wgHooks['ParserFirstCallInit'][] = 'wfScanSetSetup';
$wgScanSetSettings = array();

function wfScanSetSetup( $parser ) {
	$parser->setHook( 'scanset', 'wfScanSetHook' );
	return true;
}

function wfScanSetHook( $content, $params, $parser ) {
	global $wgScanSetSettings;

	require_once( dirname( __FILE__ ) . '/ScanSet_body.php');
	$ss = new ScanSet( $params, $parser, $wgScanSetSettings );
	return $ss->execute();
}
