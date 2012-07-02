<?php
if ( !defined('MEDIAWIKI') ) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}
/**
 *
 * @package MediaWiki
 * @subpackage PartnerFeed
 * @author Jakub Kurcek
 *
 * To use this extension $wgEnableWidgetBoxFeed = true
  */

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['ExtendedFeedItem']	= $dir . 'PartnerFeed.class.php';
$wgAutoloadClasses['PartnerRSSFeed']	= $dir . 'PartnerFeed.class.php';
$wgAutoloadClasses['PartnerAtomFeed']	= $dir . 'PartnerFeed.class.php';
$wgAutoloadClasses['PartnerFeed']	= $dir . 'PartnerFeed.body.php';

// other extensions

$wgAutoloadClasses['WikiaStatsAutoHubsConsumerDB'] =
	$GLOBALS["IP"]."/extensions/wikia/WikiaStats/WikiaStatsAutoHubsConsumerDB.php";
$wgAutoloadClasses['AutoHubsPagesHelper'] =
	$GLOBALS["IP"]."/extensions/wikia/AutoHubsPages/AutoHubsPagesHelper.class.php";


$wgExtensionMessagesFiles['PartnerFeed'] = $dir . 'PartnerFeed.i18n.php';
$wgExtensionMessagesFiles['PartnerFeedAliases'] = __DIR__ . '/PartnerFeed.aliases.php';

$wgSpecialPages['PartnerFeed']		= 'PartnerFeed';
$wgSpecialPageGroups['PartnerFeed']	= 'wikia';

//hook for purging Achievemets-related cache
$wgHooks['AchievementsInvalidateCache'][] = 'OnAchievementsInvalidateCache';

function OnAchievementsInvalidateCache( User $user ){
	wfProfileIn( __METHOD__ );
	global $wgMemc;

	//used in ParterFeed:FeedAchivementsLeaderboard()
	$rankingCacheKey = AchRankingService::getRankingCacheKey( 20 );
	$wgMemc->delete( $rankingCacheKey );

	wfProfileOut( __METHOD__ );

	return true;
}
