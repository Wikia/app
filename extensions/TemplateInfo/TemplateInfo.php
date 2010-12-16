<?php
/**
 * TemplateInfo extension
 *
 * @file
 * @ingroup Extensions
 *
 * This file contains the main include file for the TemplateInfo extension of
 * MediaWiki.
 *
 * Usage: Add the following line in LocalSettings.php:
 * require_once( "$IP/extensions/TemplateInfo/TemplateInfo.php" );
 *
 * @version 0.3
 */

// Check environment
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
	die( -1 );
}

/* Configuration */

// Credits
$wgExtensionCredits['parserhook'][] = array(
	'path'			=> __FILE__,
	'name'			=> 'TemplateInfo',
	'author'		=> array( 'Yaron Koren', 'Roan Kattouw' ),
	'version'		=> '0.3',
	'url'			=> 'http://www.mediawiki.org/wiki/Extension:TemplateInfo',
	'description'		=> 'Supports templates defining their data structure via XML markup.',
	'descriptionmsg'	=> 'templateinfo-desc',
);

// Shortcut to this extension directory
$dir = dirname( __FILE__ ) . '/';

// Internationalization
$wgExtensionMessagesFiles['TemplateInfo'] = $dir . 'TemplateInfo.i18n.php';

// Register auto load for the special page class
$wgAutoloadClasses['TemplateInfoHooks'] = $dir . 'TemplateInfo.hooks.php';
$wgAutoloadClasses['TemplateInfo'] = $dir . 'TemplateInfo.classes.php';
$wgAutoloadClasses['ApiQueryTemplateInfo'] = $dir . 'ApiQueryTemplateInfo.php';

// Register parser hook
$wgHooks['ParserFirstCallInit'][] = 'TemplateInfoHooks::register';

// Register API action
$wgAPIPropModules['templateinfo'] = 'ApiQueryTemplateInfo';
