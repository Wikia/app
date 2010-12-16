<?php
/**
 * Usability Initiative User Daily Contributions (for Click Tracking) extension
 *
 * @file
 * @ingroup Extensions
 *
 * This file contains the include file for the User Daily Contributions table in the
 * UsabilityInitiative extension of MediaWiki.
 *
 * Usage: Include the following line in your LocalSettings.php
 * require_once( "$IP/extensions/UsabilityInitiative/UserDailyContribs/UserDailyContribs.php" );
 *
 * @author Nimish Gautam <ngautam@wikimedia.org>
 * @license GPL v2 or later
 * @version 0.1.1
 */

/* Configuration */
 
// Credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'User Daily Contributions',
	'author' => 'Nimish Gautam',
	'version' => '0.1.1',
	'url' => 'http://www.mediawiki.org/wiki/Extension:UsabilityInitiative',
	'descriptionmsg' => 'userdailycontribs-desc',
);

// Includes parent extension
require_once( dirname( dirname( __FILE__ ) ) . "/UsabilityInitiative.php" );

// Adds Autoload Classes
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['UserDailyContribsHooks'] = $dir . 'UserDailyContribs.hooks.php';

// Adds Internationalized Messages
$wgExtensionMessagesFiles['UserDailyContribs'] = $dir . 'UserDailyContribs.i18n.php';

// Hooked functions
$wgHooks['LoadExtensionSchemaUpdates'][] = 'UserDailyContribsHooks::schema';
$wgHooks['ArticleSaveComplete'][] = 'UserDailyContribsHooks::storeNewContrib';
$wgHooks['ParserTestTables'][] = 'UserDailyContribsHooks::parserTestTables';
