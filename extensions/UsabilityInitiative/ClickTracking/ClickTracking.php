<?php
/**
 * Usability Initiative Click Tracking extension
 *
 * @file
 * @ingroup Extensions
 *
 * This file contains the include file for the Click Tracking portion of the
 * UsabilityInitiative extension of MediaWiki.
 *
 * Usage: Include the following line in your LocalSettings.php
 * require_once( "$IP/extensions/UsabilityInitiative/ClickTracking/ClickTracking.php" );
 *
 * @author Nimish Gautam <ngautam@wikimedia.org>
 * @license GPL v2 or later
 * @version 0.1.1
 */

/* Configuration */

// Increment this value when you change ClickTracking.js
$wgClickTrackingStyleVersion = 4;

// click throttle, should be seen as "1 out of every $wgClickTrackThrottle users will have it enabled"
// setting this to 1 means all users will have it enabled
// setting to a negative number will disable it for all users
$wgClickTrackThrottle = -1;

// set the time window for what we consider 'recent' contributions, in days
$wgClickTrackContribGranularity1 = 60 * 60 * 24 * 365 / 2; // half a year
$wgClickTrackContribGranularity2 = 60 * 60 * 24 * 365 / 4;  // 1/4 a year (3 months approx)
$wgClickTrackContribGranularity3 = 60 * 60 * 24 * 30;  //30 days (1 month approx)

// Credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Click Tracking',
	'author' => 'Nimish Gautam',
	'version' => '0.1.1',
	'descriptionmsg' => 'clicktracking-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:UsabilityInitiative'
);

// Includes parent extension
require_once( dirname( dirname( __FILE__ ) ) . "/UsabilityInitiative.php" );

// Adds Autoload Classes
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['ClickTrackingHooks'] = $dir . 'ClickTracking.hooks.php';
$wgAutoloadClasses['ApiClickTracking'] = $dir . 'ApiClickTracking.php';
$wgAutoloadClasses['SpecialClickTracking'] = $dir . 'SpecialClickTracking.php';
$wgAutoloadClasses['ApiSpecialClickTracking'] = $dir .'ApiSpecialClickTracking.php';

// Hooked functions
$wgHooks['LoadExtensionSchemaUpdates'][] = 'ClickTrackingHooks::schema';
$wgHooks['AjaxAddScript'][] = 'ClickTrackingHooks::addJS';
$wgHooks['ParserTestTables'][] = 'ClickTrackingHooks::parserTestTables';

// Set up the new API module
$wgAPIModules['clicktracking'] = 'ApiClickTracking';
$wgAPIModules['specialclicktracking'] = 'ApiSpecialClickTracking';

//Special page setup
$wgSpecialPages['ClickTracking'] = 'SpecialClickTracking';
$wgGroupPermissions['sysop']['clicktrack'] = true;

// Adds Internationalized Messages
$wgExtensionMessagesFiles['ClickTracking'] = $dir . 'ClickTracking.i18n.php';
$wgExtensionAliasesFiles['ClickTracking'] = $dir . 'ClickTracking.alias.php';
