<?php
if ( !defined('MEDIAWIKI') ) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['HubRssFeedSpecialController']	= $dir . 'HubRssFeedSpecialController.class.php';
$wgAutoloadClasses['HubRssFeedModel']	= $dir . 'HubRssFeedModel.class.php';
$wgAutoloadClasses['HubRssFeedService']	= $dir . 'HubRssFeedService.class.php';

$wgSpecialPages['HubRssFeed']		= 'HubRssFeedSpecialController';

$wgHubRssFeeds = array(
	'gaming', 'entertainment','lifestyle'
);

foreach ( $wgHubRssFeeds as $feed ) {
	if ( strtolower( $_REQUEST['title'] ) == strtolower( 'Special:HubRssFeed/'.$feed ) ) {

		/*
		 * This is used by WebRequest::interpolateTitle to overwrite title in $_GET
		 * (based on $_SERVER['REQUEST_URI']).
		 * If we are using mod_rewrite for Hubs (e.g.: /rss/Lifestyle) we need to
		 * disable this functionality in order to be able serve special page
		 * instead of regular page.
		 */
		$wgUsePathInfo = false;
		break;
	}
}