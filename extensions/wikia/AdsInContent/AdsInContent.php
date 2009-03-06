<?php
/**
 * AdsInContent Extension - Displays ad boxes inside article content
 *
 * @author Maciej Brencz <macbre(at)no-spam-wikia.com>
 * @author Adrian Wieczorek <adi(at)wikia.com>
 *
 */

if(!defined('MEDIAWIKI')) {
	echo("This file is an extension to the MediaWiki software and cannot be used standalone.\n");
	die();
}

$wgExtensionCredits['other'][] = array(
	'name' => 'AdsInContent',
	'author' => '[http://pl.inside.wikia.com/wiki/User:Macbre Maciej Brencz], [http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek]',
	'description' => 'Displays ad boxes inside article content',
	'version' => 1.1
);

$wgAdsInContentExtensionConfig = array(
	'topAdUnit' => true,
	'bottomAdUnit' => true,
	'insideAdUnit' => array( /* secttions range => array of section numbers */
		'3-5' => array(3),
		'6-*' => array(3,6)
//		'9-*' => array(3,6,8)
	),
 'insideAdUnitConfig' => array(
 	'google'     => array(
																			0 => array( 'width' => 468, 'height' => 60, 'align' => 'left', 'googleAdChannel' => '9100000015'), // 011
																			1 => array( 'width' => 200, 'height' => 200, 'align' => 'left', 'googleAdChannel' => '9100000016') // 012
 																	),
 	'yieldbuild' => array(
																			0 => array( 'width' => 468, 'height' => 200, 'align' => 'left', 'yieldbuildLocation' => 'left_first_section'),
																			1 => array( 'width' => 468, 'height' => 200, 'align' => 'left', 'yieldbuildLocation' => 'right_first_section')
 	                )
 ),
 'limit' => array(
 	'google' => 3,
 	'yieldbuild' => 4
 )
);

$wgExtensionFunctions[] = 'wfAdsInContentSetup';


/**
 * AdsInContent Extension setup function
 */
function wfAdsInContentSetup() {
	global $wgAutoloadClasses, $wgHooks;

	$wgAutoloadClasses['AdsInContent'] = dirname(__FILE__) . '/AdsInContent_body.php';
	$wgHooks['OutputPageBeforeHTML'][] = 'wfAdsInContentHook';
}

/**
 * AdsInContent Extenssion hook handler
 */
function wfAdsInContentHook(&$out, &$text) {
	global $wgAdsInContentExtensionConfig, $wgTitle, $wgUser, $wgHooks;

	$loggedIn = $wgUser->isLoggedIn();
	//$loggedIn = false;
	$ns = $wgTitle->getNamespace();
	$title = $wgTitle->getText();

	// show only for anon user in the main namespace (if article exists)
	if( ($ns == NS_MAIN) && !$loggedIn && $wgTitle->exists() && !AdsInContent::isMainPage()) {
		$wgHooks['SkinAfterBottomScripts'][] = 'AdsInContent::applyTopSectionJSFix';

		$adsInContent = new AdsInContent($text, $wgAdsInContentExtensionConfig);
		$adsInContent->execute();
	}
	return true;
}

