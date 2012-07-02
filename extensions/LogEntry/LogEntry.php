<?php
/**
 * LogEntry extension
 *
 * @file
 * @ingroup Extensions
 * 
 * This file contains the main include file for the LogEntry extension of
 * MediaWiki.
 *
 * Usage: Add the following line in LocalSettings.php:
 * require_once( "$IP/extensions/LogEntry/LogEntry.php" );
 *
 * @author Trevor Parscal <tparscal@wikimedia.org>
 * @license GPL v2
 * @version 0.1.0
 */

// Check environment
if( !defined( 'MEDIAWIKI' ) ) {
    echo( "This is an extension to the MediaWiki package and cannot be run standalone.\n" );
    die( -1 );
}

/* Configuration */

// Credits
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'LogEntry',
	'author'         => 'Trevor Parscal', 
	'url'            => 'https://www.mediawiki.org/wiki/Extension:LogEntry', 
	'descriptionmsg' => 'logentry-parserhook-desc',
);

// Show TimeStamp == true, No TimeStamp == false
$egLogEntryTimeStamp = true;

// Show UserName == true, No UserName == false
$egLogEntryUserName = true;

// Use MultiLine == true, Use SingleLine == false
$egLogEntryMultiLine = false;

// Number of rows if MultiLine is enabled
$egLogEntryMultiLineRows = 3;

// Shortcut to this extension directory
$dir = dirname( __FILE__ ) . '/';

// Internationalization
$wgExtensionMessagesFiles['LogEntry'] = $dir . 'LogEntry.i18n.php';
$wgExtensionMessagesFiles['LogEntryAlias'] = $dir . 'LogEntry.alias.php';

// Register auto load for the special page class
$wgAutoloadClasses['LogEntryHooks'] = $dir . 'LogEntry.hooks.php';
$wgAutoloadClasses['SpecialLogEntry'] = $dir . 'LogEntry.page.php';

// Register parser hook
$wgHooks['ParserFirstCallInit'][] = 'LogEntryHooks::register';

// Register the LogEntry special page
$wgSpecialPages['LogEntry'] = 'SpecialLogEntry';
