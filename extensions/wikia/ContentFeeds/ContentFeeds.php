<?php
/**
 * Content Feeds Extensions - provides a rich and up to date information through various tags or "feeds"
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 */

if(!defined('MEDIAWIKI')) {
	die();
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Content Feeds',
	'author' => 'Adrian \'ADi\' Wieczorek',
	'url' => 'http://www.wikia.com' ,
	'description' => 'provides a rich and up to date information through various tags or "feeds"',
	'descriptionmsg' => 'contentfeeds-desc'
);


/**
 * setup functions
 */
$wgExtensionFunctions[] = 'wfContentFeedsInit';

function wfContentFeedsInit() {
	global $wgHooks, $wgExtensionMessagesFiles, $wgAutoloadClasses;

	$dir = dirname(__FILE__) . '/';

	/**
	 * hooks
	 */
	$wgHooks['ParserFirstCallInit'][] = 'wfContentFeedsInitParserHooks';
	$wgHooks['SpecialNewImages::beforeDisplay'][] = 'ContentFeeds::specialNewImagesHook';
	$wgHooks['ParserBeforeStrip'][] = 'ContentFeeds::recentImagesParserHook';

	/**
	 * messages file
	 */
	$wgExtensionMessagesFiles['ContentFeeds'] = $dir . 'ContentFeeds.i18n.php';

	/**
	 * classes
	 */
	$wgAutoloadClasses['ContentFeeds'] = $dir . 'ContentFeeds.class.php';
}

	/**
	 * ajax calls
	 */
	//$wgAjaxExportList[] = '';

function wfContentFeedsInitParserHooks( &$parser ) {
	wfLoadExtensionMessages('ContentFeeds');

	$parser->setHook( 'mostvisited', 'ContentFeeds::mostVisitedParserHook' );
	$parser->setHook( 'wikitweets', 'ContentFeeds::wikiTweetsParserHook' );
	$parser->setHook( 'twitteruser', 'ContentFeeds::userTweetsParserHook' );
	$parser->setHook( 'newpageslist', 'ContentFeeds::newPagesListParserHook' );
	$parser->setHook( 'topuserslist', 'ContentFeeds::topUsersListParserHook' );
	$parser->setHook( 'highestrated', 'ContentFeeds::highestRatedParserHook' );
	$parser->setHook( 'recentimages', 'ContentFeeds::dummyRecentImagesParserHook' );
	// TODO: turned off until it's ready
	//$parser->setHook( 'firstfewarticles', 'ContentFeeds::firstFewArticlesParserHook' );

	return true;
}
