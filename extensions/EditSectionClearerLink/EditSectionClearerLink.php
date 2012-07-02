<?php
/**
 * EditSectionClearerLink extension
 *
 * @file
 * @ingroup Extensions
 *
 * This extension makes the section edit links clearer.  It:
 *  - moves the links next to the section title without a parser patch
 *  - adds a hover action that highlights the edit link when the mouse is placed on the section
 *  - adds an outline around the section when the mouse hovers over the link
 *
 * It is intended to make the links easier to notice, and to clarify which section will be edited when
 * the link is clicked.
 *
 * Usage: Add the following line in LocalSettings.php:
 * require_once( "$IP/extensions/EditSectionClearerLink/EditSectionClearerLink.php" );
 *
 * Based on EditSectionHiliteLink by Arash Boostani
 *
 * @author Ian Baker <ian@wikimedia.org>
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
	'name' => 'EditSectionClearerLink',
	'author' => 'Ian Baker',
	'version' => '0.1.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:EditSectionClearerLink',
	'descriptionmsg' => 'editsectionclearerlink-desc',
);

// Shortcut to this extension directory
$dir = dirname( __FILE__ ) . '/';

// resources that need loading
$wgResourceModules['ext.editSectionClearerLink'] = array(
	'styles' => 'EditSectionClearerLink.css',
	'scripts' => 'EditSectionClearerLink.js',
	'localBasePath' => $dir,
	'remoteExtPath' => 'EditSectionClearerLink'
);

$wgExtensionMessagesFiles['EditSectionClearerLink'] = $dir . 'EditSectionClearerLink.i18n.php';

# Bump the version number every time you change any of the .css/.js files
$wgEditSectionClearerLinkStyleVersion = 2;

$wgAutoloadClasses['EditSectionClearerLinkHooks'] = $dir . 'EditSectionClearerLink.hooks.php';

// Register edit link create hook
$wgHooks['DoEditSectionLink'][] = 'EditSectionClearerLinkHooks::reviseLink';

// Register section create hook
$wgHooks['ParserSectionCreate'][] = 'EditSectionClearerLinkHooks::reviseSection';

// Register css add script hook
$wgHooks['OutputPageParserOutput'][] = 'EditSectionClearerLinkHooks::addPageResources';
