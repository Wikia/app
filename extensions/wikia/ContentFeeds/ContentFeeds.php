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
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ContentFeeds',
	'descriptionmsg' => 'contentfeeds-desc'
);


/**
 * setup functions
 */
$wgExtensionFunctions[] = 'wfContentFeedsInit';

function wfContentFeedsInit() {
	global $wgHooks, $wgAutoloadClasses;

	$dir = dirname(__FILE__) . '/';

	/**
	 * hooks
	 */
	$wgHooks['ParserFirstCallInit'][] = 'wfContentFeedsInitParserHooks';
	$wgHooks['SpecialNewImages::beforeDisplay'][] = 'ContentFeeds::specialNewImagesHook';
	$wgHooks['ParserBeforeStrip'][] = 'ContentFeeds::recentImagesParserHook';

	/**
	 * classes
	 */
	$wgAutoloadClasses['ContentFeeds'] = $dir . 'ContentFeeds.class.php';
}

/**
 * @param Parser $parser
 * @return bool
 */
function wfContentFeedsInitParserHooks( Parser $parser ): bool {
	$parser->setHook( 'mostvisited', 'ContentFeeds::mostVisitedParserHook' );
	$parser->setHook( 'wikitweets', 'ContentFeeds::wikiTweetsParserHook' );
	$parser->setHook( 'twitteruser', 'ContentFeeds::userTweetsParserHook' );
	$parser->setHook( 'newpageslist', 'ContentFeeds::newPagesListParserHook' );
	$parser->setHook( 'topuserslist', 'ContentFeeds::topUsersListParserHook' );
	$parser->setHook( 'highestrated', 'ContentFeeds::highestRatedParserHook' );
	$parser->setHook( 'recentimages', 'ContentFeeds::dummyRecentImagesParserHook' );

	return true;
}
