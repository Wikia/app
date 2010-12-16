<?php
/**
 * Drafts extension
 *
 * @file
 * @ingroup Extensions
 *
 * This file contains the main include file for the Drafts extension of
 * MediaWiki.
 *
 * Usage: Add the following line in LocalSettings.php:
 * require_once( "$IP/extensions/Drafts/Drafts.php" );
 *
 * @author Trevor Parscal <tparscal@wikimedia.org>
 * @license GPL v2
 * @version 0.1.0
 */

// Check environment
if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This is an extension to MediaWiki and cannot be run standalone.\n" );
	die( - 1 );
}

/* Configuration */

// Credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Drafts',
	'author' => 'Trevor Parscal',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Drafts',
	'description' => 'Save and view draft versions of pages',
	'descriptionmsg' => 'drafts-desc',
);

// Shortcut to this extension directory
$dir = dirname( __FILE__ ) . '/';

# Bump the version number every time you change any of the .css/.js files
$wgDraftsStyleVersion = 3;

// Seconds of inactivity after change before autosaving
// Use the value 0 to disable autosave
$egDraftsAutoSaveWait = 120;

// Seconds to wait until giving up on a response from the server
// Use the value 0 to disable autosave
$egDraftsAutoSaveTimeout = 10;

// Days to keep drafts around before automatic deletion
$egDraftsLifeSpan = 30;

// Ratio of times which a list of drafts requested and the list should be pruned
// for expired drafts - expired drafts will not apear in the list even if they
// are not yet pruned, this is just a way to keep the database from filling up
// with old drafts
$egDraftsCleanRatio = 1000;

// Save and View components
$wgAutoloadClasses['Drafts'] = $dir . 'Drafts.classes.php';
$wgAutoloadClasses['Draft'] = $dir . 'Drafts.classes.php';
$wgAutoloadClasses['DraftHooks'] = $dir . 'Drafts.hooks.php';

// Internationalization
$wgExtensionMessagesFiles['Drafts'] = $dir . 'Drafts.i18n.php';
$wgExtensionAliasesFiles['Drafts'] = $dir . 'Drafts.alias.php';

// Register the Drafts special page
$wgSpecialPages['Drafts'] = 'DraftsPage';
$wgSpecialPageGroups['Drafts'] = 'pagetools';
$wgAutoloadClasses['DraftsPage'] = $dir . 'Drafts.pages.php';

// Register save interception to detect non-javascript draft saving
$wgHooks['EditFilter'][] = 'DraftHooks::interceptSave';

// Register article save hook
$wgHooks['ArticleSaveComplete'][] = 'DraftHooks::discard';

// Updates namespaces and titles of drafts to new locations after moves
$wgHooks['SpecialMovepageAfterMove'][] = 'DraftHooks::move';

// Register controls hook
$wgHooks['EditPageBeforeEditButtons'][] = 'DraftHooks::controls';

// Register load hook
$wgHooks['EditPage::showEditForm:initial'][] = 'DraftHooks::loadForm';

// Register ajax response hook
$wgAjaxExportList[] = 'DraftHooks::save';

// Register ajax add script hook
$wgHooks['AjaxAddScript'][] = 'DraftHooks::addJS';

// Register css add script hook
$wgHooks['BeforePageDisplay'][] = 'DraftHooks::addCSS';

// Register database operations
$wgHooks['LoadExtensionSchemaUpdates'][] = 'DraftHooks::schema';

