<?php
/**
 * jQueryMsg extension
 *
 * @file
 * @ingroup Extensions
 *
 * This extension creates a $.msg() function.  It's based on Neilk's similar code
 * from UploadWizard, and is pretty awesome.
 *
 * It is also similar to Wikia's JSMessaging extension, except its parser is much
 * more comprehensive.
 *
 * Usage: Add the following line in LocalSettings.php:
 * require_once( "$IP/extensions/jQueryMsg/jQueryMsg.php" );
 *
 * @author Neil Kandalgaonkar <neilk@wikimedia.org> and Ian Baker <ian@wikimedia.org>
 * @license GPL v2
 * @version 0.1.0
 */

// Check environment
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This is an extension to MediaWiki and cannot be run standalone.\n" );
	die( - 1 );
}

// Credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'jQueryMsg',
	'author' => array( 'Neil Kandalgaonkar', 'Ian Baker' ),
	'version' => '0.1.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:jQueryMsg',
	'descriptionmsg' => 'jquerymsg-desc',
);

// Shortcut to this extension directory
$dir = dirname( __FILE__ ) . '/';

// resources that need loading
$wgResourceModules['ext.jQueryMsg'] = array(
	'scripts' => array(
		'resources/mediawiki.language.parser.js',
		'jQueryMsg.js'
	),
	'dependencies' => array(
		'jquery',
		'mediawiki.language',
		'mediawiki.util'
	),
	'localBasePath' => $dir,
	'remoteExtPath' => 'jQueryMsg'
);

$wgExtensionMessagesFiles['jQueryMsg'] = $dir . 'jQueryMsg.i18n.php';
