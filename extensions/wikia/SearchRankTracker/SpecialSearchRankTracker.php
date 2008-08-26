<?php
/**
 * SearchRankTracker extension
 * 
 * This extension tracks wiki page position (rank) for given phrase in search engines.
 * 
 * (Based on code originaly written by Tomek Klim) 
 * 
 * !IMPORTANT! Please see SearchRankTracker.sql for db shema !IMPORTANT! 
 * 
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 * 
 */

if(!defined('MEDIAWIKI')) {
	echo("This file is an extension to the MediaWiki software and cannot be used standalone.\n");
	die();
}

/* we want extension to be hidden on Special:Version
$wgExtensionCredits['other'][] = array(
	'name' => 'SearchRankTracker',
	'author' => '[http://www.wikia.com/wiki/User:Adi3ek Adrian \'ADi\' Wieczorek]',
	'description' => 'Track wiki page position (rank) for given phrase in various search engines.',
	'version' => 0.9
);
*/

// extension config
$wgSearchRankTrackerConfig = array(
	'searchEngines' => array(
		'google' => array( 'graphColor' => 'red', 'graphMark' => 9 ),
		'yahoo' => array( 'graphColor' => 'blue', 'graphMark' => 12 ),
		'MSN' => array( 'graphColor' => 'green', 'graphMark' => 7 ),
		'altavista' => array( 'graphColor' => 'orange', 'graphMark' => 8)
	),
	'graphDaysBackNum' => 61
);

// permissions
$wgAvailableRights[] = 'searchranktracker';
$wgGroupPermissions['staff']['searchranktracker'] = true;
$wgGroupPermissions['ranktracker']['searchranktracker'] = true;

// classes
$wgAutoloadClasses['SearchRankEntry'] = dirname(__FILE__) . '/SearchRankEntry.class.php';
$wgAutoloadClasses['SearchRankBot'] = dirname(__FILE__) . '/SearchRankBot.class.php';

// Special page
extAddSpecialPage(dirname(__FILE__) . '/SpecialSearchRankTracker_body.php', 'SearchRankTracker', 'SearchRankTracker');

// Ajax handler
function axWSearchRankCheckPage() {
	return SearchRankTracker::axCheckPage();
}
$wgAjaxExportList[] = "axWSearchRankCheckPage";
