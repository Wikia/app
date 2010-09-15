<?php
if ( !defined('MEDIAWIKI') ) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}
/**
 *
 * @package MediaWiki
 * @subpackage WidgetBox
 * @author Jakub Kurcek
 *
 * To use this extension $wgEnableWidgetBoxFeed = true
 * Remember: when you add autoloadClasses, add them to maintenance/wikia/WidgetBoxHotContentImageGenerator.php too.
 */

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['ExtendedFeedItem']	= $dir . 'WidgetBoxRSS.class.php';
$wgAutoloadClasses['WidgetBoxRSSFeed']	= $dir . 'WidgetBoxRSS.class.php';
$wgAutoloadClasses['WidgetBoxAtomFeed'] = $dir . 'WidgetBoxRSS.class.php';
$wgAutoloadClasses['WidgetBoxRSS']	= $dir . 'WidgetBoxRSS.body.php';

// other extensions

$wgAutoloadClasses['WikiaStatsAutoHubsConsumerDB'] =
	$GLOBALS["IP"]."/extensions/wikia/WikiaStats/WikiaStatsAutoHubsConsumerDB.php";
$wgAutoloadClasses['AutoHubsPagesHelper'] =
	$GLOBALS["IP"]."/extensions/wikia/AutoHubsPages/AutoHubsPagesHelper.class.php";


$wgExtensionMessagesFiles['WidgetBoxRSS'] = $dir . 'WidgetBoxRSS.i18n.php';

$wgSpecialPages['WidgetBoxRSS']		= 'WidgetBoxRSS';
$wgSpecialPageGroups['WidgetBoxRSS']	= 'wikia';

