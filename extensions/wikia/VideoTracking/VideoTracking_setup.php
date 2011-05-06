<?php
/**
 *
 * @package MediaWiki
 * @subpackage VideoTracking
 * @author Jakub Kurcek
 *
 * To use this extension $wgEnableSponsorshipDashboardExt = true
 */


if(!defined('MEDIAWIKI')) {
	exit(1);
}

if ( !defined('MEDIAWIKI') ) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'VideoTracking',
	'descriptionmsg' => 'videotracking-desc',
	'author' => 'Jakub Kurcek',
);

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['VideoTracker']	= $dir . 'VideoTracker.class.php';
$wgHooks['BeforePageDisplay'][] = 'VideoTracker::onBeforePageDisplay';


