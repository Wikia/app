<?php
/**
 * InterfaceConcurrency extension
 *
 * @file
 * @ingroup Extensions
 *
 * Backend for cooperative locking of web resources
 *
 * Each resource is identified by a combination of the "resource type" (the application, the type
 * of content, etc), and the resource's primary key or some other unique numeric ID.
 *
 * Primarily, this extension provides an API for accessing the functionality.  It should probably be
 * rolled into core after 1.19 is branched.
 *
 * Usage: Add the following line in LocalSettings.php:
 * require_once( "$IP/extensions/InterfaceConcurrency/InterfaceConcurrency.php" );
 *
 * @author Ian Baker <ian@wikimedia.org>, Benny Situ <bsitu@wikimedia.org>
 * @license GPL v2
 * @version 0.1.0
 */

// Check environment
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This is an extension to MediaWiki and cannot be run standalone.\n" );
	die( -1 );
}

// Credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'InterfaceConcurrency',
	'author' => array( 'Ian Baker', 'Benny Situ' ),
	'version' => '0.1.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:InterfaceConcurrency',
	'descriptionmsg' => 'interfaceconcurrency-desc',
);

// Shortcut to this extension directory
$dir = dirname( __FILE__ ) . '/';

// Object model
$wgExtensionMessagesFiles['InterfaceConcurrency'] = $dir . 'InterfaceConcurrency.i18n.php';
$wgAutoloadClasses['ConcurrencyCheck'] = $dir . 'includes/ConcurrencyCheck.php';

// API
$wgAutoloadClasses['ApiConcurrency'] = $dir . 'ApiConcurrency.php';
$wgAPIModules['concurrency'] = 'ApiConcurrency';

// Hooks
$wgAutoloadClasses['InterfaceConcurrencyHooks'] = $dir . 'InterfaceConcurrency.hooks.php';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'InterfaceConcurrencyHooks::onLoadExtensionSchemaUpdates';

// Resources
$icResourceTemplate = array(
	'localBasePath' => $dir . 'modules',
	'remoteExtPath' => 'InterfaceConcurrency/modules'
);

$wgResourceModules['jquery.interfaceConcurrency'] = $icResourceTemplate + array(
	'scripts' => 'jquery.interfaceConcurrency/jquery.interfaceConcurrency.js',
	'dependencies' => array(
		'mediawiki.util',
		'user.tokens',
	),
);

// Configuration
$wgInterfaceConcurrencyConfig = array(
	'ExpirationDefault' => 60 * 15, // Default checkout duration. 15 minutes.
	'ExpirationMax' => 60 * 30, // Maximum possible checkout duration. 30 minutes.
	'ExpirationMin' => 1, // Minimum possible checkout duration.  Negative is possible for testing if you want.
	'ListMaxAge' => 60, // How stale (in seconds) can listCheckouts() be?	
);
