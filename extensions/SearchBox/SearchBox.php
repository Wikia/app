<?php
/**
 * SearchBox extension
 *
 * @file
 * @ingroup Extensions
 *
 * This file contains the main include file for the SearchBox extension of
 * MediaWiki.
 *
 * Usage: Add the following line in LocalSettings.php:
 * require_once( "$IP/extensions/SearchBox/SearchBox.php" );
 *
 * @author Trevor Parscal <tparscal@wikimedia.org>
 * @license GPL v2
 * @version 0.1.0
 */

// Check environment
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
	die( -1 );
}

/* Configuration */

// Credits
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'SearchBox',
	'author'         => array( 'Trevor Parscal' ),
	'url'            => 'https://www.mediawiki.org/wiki/Extension:SearchBox',
	'descriptionmsg' => 'searchbox-desc',
);

// Shortcut to this extension directory
$dir = dirname( __FILE__ ) . '/';

// Internationalization
$wgExtensionMessagesFiles['SearchBox'] = $dir . 'SearchBox.i18n.php';

// Register auto load for the special page class
$wgAutoloadClasses['SearchBoxHooks'] = $dir . 'SearchBox.hooks.php';

// Register parser hook
$wgHooks['ParserFirstCallInit'][] = array( 'SearchBoxHooks::register' );
