<?php
/**
 * Usability Initiative PrefStats extension
 *
 * @file
 * @ingroup Extensions
 *
 * This file contains the include file for the EditWarning portion of the
 * UsabilityInitiative extension of MediaWiki.
 *
 * Usage: Include the following line in your LocalSettings.php
 * require_once( "$IP/extensions/UsabilityInitiative/PrefStats/PrefStats.php" );
 *
 * @author Roan Kattouw <roan.kattouw@gmail.com>
 * @license GPL v2 or later
 * @version 0.1.1
 */

/* Configuration */

// For this extension to actually do anything, you need to configure
// $wgPrefStatsTrackPrefs yourself.

// Set to false to disable tracking
$wgPrefStatsEnable = true;

// array('prefname' => 'value')
// value can't be the default value
// Tracking multiple values of the same preference is not possible
$wgPrefStatsTrackPrefs = array();

// Dimensions of the chart on Special:PrefStats
$wgPrefStatsChartDimensions = array( 800, 300 );

// Time unit to use for the graph on Special:PrefStats
// Don't change this unless you know what you're doing
$wgPrefStatsTimeUnit = 60 * 60; // one hour

// Multiples of $wgPrefStatsTimeUnit to offer
// array( messagekey => factor )
$wgPrefStatsTimeFactors = array(
	'prefstats-factor-hour' => 1,
	'prefstats-factor-sixhours' => 6,
	'prefstats-factor-day' => 24,
	'prefstats-factor-week' => 7*24,
	'prefstats-factor-twoweeks' => 2*7*24,
	'prefstats-factor-fourweeks' => 4*7*24,
	'prefstats-factor-default' => null,
);

// How many bars to strive for in default scaling
$wgPrefStatsDefaultScaleBars = 15;

// Whether to run possibly expensive COUNT(*) queries on the user_properties
// table
$wgPrefStatsExpensiveCounts = false;

// For how long statistics should be cached
// Set to false to disable caching
$wgPrefStatsCacheTime = 60 * 60; // one hour

/* Setup */

// Credits
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'PrefStats',
	'author' => 'Roan Kattouw',
	'version' => '0.1.1',
	'url' => 'http://www.mediawiki.org/wiki/Extension:UsabilityInitiative',
	'descriptionmsg' => 'prefstats-desc',
);

// Includes parent extension
require_once( dirname( dirname( __FILE__ ) ) . "/UsabilityInitiative.php" );

// Adds Autoload Classes
$wgAutoloadClasses['PrefStatsHooks'] =
	dirname( __FILE__ ) . '/PrefStats.hooks.php';
$wgAutoloadClasses['SpecialPrefStats'] =
	dirname( __FILE__ ) . '/SpecialPrefStats.php';

$wgSpecialPages['PrefStats'] = 'SpecialPrefStats';
$wgSpecialPageGroups['PrefStats'] = 'wiki';

// Adds Internationalized Messages
$wgExtensionMessagesFiles['PrefStats'] =
	dirname( __FILE__ ) . '/PrefStats.i18n.php';
$wgExtensionAliasesFiles['PrefStats'] =
	dirname( __FILE__ ) . '/PrefStats.alias.php';

// Registers Hooks
$wgHooks['LoadExtensionSchemaUpdates'][] = 'PrefStatsHooks::schema';
$wgHooks['UserSaveOptions'][] = 'PrefStatsHooks::save';
