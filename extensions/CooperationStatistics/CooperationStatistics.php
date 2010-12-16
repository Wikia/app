<?php
/**
 * A special page to show Cooperation Statistics.
 *
 */

// If this is run directly from the web die as this is not a valid entry point.
if ( !defined( 'MEDIAWIKI' ) ) die( 'Invalid entry point.' );

$wgCooperationStatsGoogleCharts = true; // false to disable charts
$wgCoopStatsChartDimensions = '520x200';
$wgCoopStatsChartBarDimensions = '180x200';

// Extension credits.
$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'CooperationStatistics',
	'version'        => '1.0',
	'author'         => 'Al Maghi',
	'email'          => 'alfred.maghi@gmail.com',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:CooperationStatistics',
	'description'    => '',
	'descriptionmsg' => 'cooperationstatistics-desc',
);

// Set extension files.
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['CooperationStatistics'] = $dir . 'CooperationStatistics.i18n.php';
$wgExtensionAliasesFiles['CooperationStatistics'] = $dir . 'CooperationStatistics.alias.php';
$wgAutoloadClasses['CooperationStatistics'] = $dir . 'CooperationStatistics_body.php';
$wgSpecialPages['CooperationStatistics'] = 'CooperationStatistics';
$wgSpecialPageGroups['CooperationStatistics'] = 'wiki';
