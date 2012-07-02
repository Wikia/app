<?php
/**
 * PrefStats extension
 *
 * @file
 * @ingroup Extensions
 *
 * @author Roan Kattouw <roan.kattouw@gmail.com>
 * @author Trevor Parscal <tparscal.kattouw@gmail.com>
 * @license GPL v2 or later
 * @version 0.2.0
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

// Multiples of $wgPrefStatsTimeUnit to offer -- array( messagekey => factor )
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

// Whether to run possibly expensive COUNT(*) queries on the user_properties table
$wgPrefStatsExpensiveCounts = false;

// For how long statistics should be cached
// Set to false to disable caching
$wgPrefStatsCacheTime = 60 * 60; // one hour

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'PrefStats',
	'author' => array( 'Roan Kattouw', 'Trevor Parscal' ),
	'version' => '0.2.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:PrefStats',
	'descriptionmsg' => 'prefstats-desc',
);
$dir = dirname( __FILE__ ) . '/';
$wgAutoloadClasses['PrefStatsHooks'] = $dir . 'PrefStats.hooks.php';
$wgAutoloadClasses['SpecialPrefStats'] = $dir . 'SpecialPrefStats.php';
$wgSpecialPages['PrefStats'] = 'SpecialPrefStats';
$wgSpecialPageGroups['PrefStats'] = 'wiki';
$wgExtensionMessagesFiles['PrefStats'] = $dir . 'PrefStats.i18n.php';
$wgExtensionMessagesFiles['PrefStatsAlias'] = $dir . 'PrefStats.alias.php';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'PrefStatsHooks::loadExtensionSchemaUpdates';
$wgHooks['UserSaveOptions'][] = 'PrefStatsHooks::userSaveOptions';
