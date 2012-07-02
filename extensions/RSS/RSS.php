<?php
/**
 * RSS-Feed MediaWiki extension
 *
 * @file
 * @ingroup Extensions
 * @version 1.90
 * @author mutante, Daniel Kinzler, Rdb, Mafs, Thomas Gries, Alxndr, Chris Reigrut, K001
 * @author Kellan Elliott-McCrea <kellan@protest.net> -- author of MagpieRSS
 * @author Jeroen De Dauw
 * @author Jack Phoenix <jack@countervandalism.net>
 * @copyright © Kellan Elliott-McCrea <kellan@protest.net>
 * @copyright © mutante, Daniel Kinzler, Rdb, Mafs, Thomas Gries, Alxndr, Chris Reigrut, K001
 * @link http://www.mediawiki.org/wiki/Extension:RSS Documentation
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'RSS feed',
	'author' => array( 'Kellan Elliott-McCrea', 'mutante', 'Daniel Kinzler',
		'Rdb', 'Mafs', 'Alxndr', 'Thomas Gries', 'Chris Reigrut',
		'K001', 'Jack Phoenix', 'Jeroen De Dauw', 'Mark A. Hershberger'
	),
	'version' => '1.90 20110815',
	'url' => 'https://www.mediawiki.org/wiki/Extension:RSS',
	'descriptionmsg' => 'rss-desc',
);

// Internationalization file and autoloadable classes
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['RSS'] = $dir . 'RSS.i18n.php';
$wgAutoloadClasses['RSSHooks'] = $dir . 'RSSHooks.php';
$wgAutoloadClasses['RSSParser'] = $dir . 'RSSParser.php';
$wgAutoloadClasses['RSSData'] = $dir . 'RSSData.php';

$wgHooks['ParserFirstCallInit'][] = 'RSSHooks::parserInit';

 // one hour
 $wgRSSCacheAge = 3600;

// Check cached content, if available, against remote.
// $wgRSSCacheCompare should be set to false or a timeout
// (less than $wgRSSCacheAge) after which a comparison will be made.
$wgRSSCacheCompare = false;

// 5 second timeout
$wgRSSFetchTimeout = 5;

// Ignore the RSS tag in all but the namespaces listed here.
// null (the default) means the <rss> tag can be used anywhere.
$wgRSSNamespaces = null;

// URL whitelist of RSS Feeds:
// if there are items in the array, and the used URL isn't in the array,
// it will not be allowed (originally proposed in bug 27768)
$wgRSSAllowedFeeds = array();

// Agent to use for fetching feeds
$wgRSSUserAgent = 'MediaWikiRSS/0.02 (+http://www.mediawiki.org/wiki/Extension:RSS) / MediaWiki RSS extension';

// Proxy server to use for fetching feeds
$wgRSSProxy = false;
