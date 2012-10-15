<?php

/**
 * Provides hover-over tool tips on articles from words defined on the
 * Terminology page.
 *
 * @file
 * @defgroup Lingo
 * @author Barry Coughlan
 * @copyright 2010 Barry Coughlan
 * @author Stephan Gambke
 * @version 0.3
 * @licence GNU General Public Licence 2.0 or later
 * @see http://www.mediawiki.org/wiki/Extension:Lingo Documentation
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is part of a MediaWiki extension, it is not a valid entry point.' );
}

define( 'LINGO_VERSION', '0.3' );


// set defaults for settings

// set the backend to access the glossary
$wgexLingoBackend = 'LingoBasicBackend';

// set default for Terminology page (null = take from i18n)
$wgexLingoPage = null;

// set if glossary terms are to be marked up once or always
$wgexLingoDisplayOnce = false;

// set namespaces to be marked up;
// namespaces to be ignored have to be included in this array and set to false
// anything not in this array (or in this array and set to true) will be marked up
$wgexLingoUseNamespaces = array(
//	NS_MEDIA            => true,
//	NS_SPECIAL          => true,
//	NS_TALK             => false,
//  ...
);


// set extension credits
// (no description here, will be set later)
$wgExtensionCredits['parserhook']['lingo'] = array(
	'path' => __FILE__,
	'name' => 'Lingo',
	'author' => array('Barry Coughlan', '[http://www.mediawiki.org/wiki/User:F.trott Stephan Gambke]'),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Lingo',
	'version' => LINGO_VERSION,
);

// server-local path to this file
$dir = dirname( __FILE__ );

// register message files
$wgExtensionMessagesFiles['Lingo'] = $dir . '/Lingo.i18n.php';
$wgExtensionMessagesFiles['LingoMagic'] = $dir . '/Lingo.i18n.magic.php';

// register class files with the Autoloader
$wgAutoloadClasses['LingoHooks'] = $dir . '/LingoHooks.php';
$wgAutoloadClasses['LingoParser'] = $dir . '/LingoParser.php';
$wgAutoloadClasses['LingoTree'] = $dir . '/LingoTree.php';
$wgAutoloadClasses['LingoElement'] = $dir . '/LingoElement.php';
$wgAutoloadClasses['LingoBackend'] = $dir . '/LingoBackend.php';
$wgAutoloadClasses['LingoBasicBackend'] = $dir . '/LingoBasicBackend.php';
$wgAutoloadClasses['LingoMessageLog'] = $dir . '/LingoMessageLog.php';

// register hook handlers
$wgHooks['SpecialVersionExtensionTypes'][] = 'LingoHooks::setCredits'; // set credits
$wgHooks['ParserAfterTidy'][] = 'LingoHooks::parse'; // parse page

// register resource modules with the Resource Loader
$wgResourceModules['ext.Lingo.Styles'] = array(
	'localBasePath' => $dir,
	'remoteExtPath' => 'Lingo',
	// 'scripts' => 'libs/ext.myExtension.js',
	'styles' => 'skins/Lingo.css',
	// 'messages' => array( 'myextension-hello-world', 'myextension-goodbye-world' ),
	// 'dependencies' => array( 'jquery.ui.datepicker' ),
);

$wgResourceModules['ext.Lingo.Scripts'] = array(
	'localBasePath' => $dir,
	'remoteExtPath' => 'Lingo',
	'scripts' => 'libs/Lingo.js',
	// 'styles' => 'skins/Lingo.css',
	// 'messages' => array( 'myextension-hello-world', 'myextension-goodbye-world' ),
	// 'dependencies' => array( 'jquery.ui.datepicker' ),
);

MagicWord::$mDoubleUnderscoreIDs[] = 'noglossary';

unset( $dir );

