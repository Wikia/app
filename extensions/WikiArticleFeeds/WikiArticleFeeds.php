<?php
/*
 * WikiArticleFeeds.php - A MediaWiki extension for converting regular pages into feeds.
 * @author Jim R. Wilson
 * @version 0.6.5
 * @copyright Copyright (C) 2007 Jim R. Wilson
 * @license The MIT License - http://www.opensource.org/licenses/mit-license.php 
 * -----------------------------------------------------------------------
 * Description:
 *     This is a MediaWiki (http://www.mediawiki.org/) extension which adds support
 *     for publishing RSS or Atom feeds generated from standard wiki articles.
 * Requirements:
 *     MediaWiki 1.6.x or higher
 *     PHP 4.x, 5.x or higher
 * Installation:
 *     1. Drop this script (WikiArticleFeeds.php) in $IP/extensions
 *         Note: $IP is your MediaWiki install dir.
 *     2. Enable the extension by adding this line to your LocalSettings.php:
 *            require_once('extensions/WikiArticleFeeds.php');
 * Usage:
 *     Once installed, you may utilize WikiArticleFeeds by invoking the 'feed' action of an article:
 *         $wgScript?title=Some_Article&action=feed
 *     Note: You may optionally supply a feed type.  Acceptable values inculde 'rss' and 'atom'.
 *     If no feed type is specified, the default is 'atom'.  For example: 
 *         $wgScript?title=Some_Article&action=feed&feed=atom
 * Creating a Feed:
 *     To delimit a section of an article as containing feed items, use the <startFeed /> 
 *     and <endFeed /> tags respectively.  These tags are merely flags, and any attributes
 *     specified, or content inside the tags themselves will be ignored.
 * Tagging a Feed item:
 *     To tag a feed item, insert either the <itemTags> tag, or the a call to the {{#itemTags}} parser 
 *     function somewhere between the opening header of the item (== Item Title ==) and the header of 
 *     the next item.  For example, to mark an item about dogs and cats, you could do any of the following:
 *         <itemTags>dogs, cats</itemTags>
 *         {{#itemTags:dogs, cats}}
 *         {{#itemTags:dogs|cats}}
 * Version Notes:
 *     version 0.6.5:
 *         Simplified many regular expression to get it working on MW 1.16
 *     version 0.6.4:
 *         Small fix for MW 1.14 in which section header anchors changed format.
 *         First version to be checked into wikimedia SVN.
 *     version 0.6.3:
 *         Wrapped extension points for versions less than 1.7 (old version compatibility)
 *     version 0.6.2:
 *         Added support for alternate signatures (when users are not in the User namespace)
 *         Tied purge of xml feeds to purge of page - helps with consumers of semantic and DPL
 *             (Thanks to Charlie Huggard of charlie.huggardlee.net for these contributions)
 *     version 0.6.1:
 *         Fixed stale feed problem by expiring the feed cache when any of an article's transcluded pages change.
 *     version 0.6:
 *         Added support for "tagging" feed items by way of <itemTags> or {{itemTags}}
 *         Added support for filtering generated feed based on item tags.
 *         Added global ($wgWikiArticleFeedsSkipCache) used for skipping object-cache while debugging.
 *         Fixed namespace restriction - now works for namespaces other than NS_MAIN
 *     version 0.5:
 *         Now supports offloading to FeedBurner (http://feedburner.com/) via <feedBurner> tag.
 *         Capitalized RSS and Atom links in the toolbox.
 *     version 0.4:
 *         Added wgForceArticleFeedSectionLinks to override default link behavior (set in LocalSettings).
 *         Feed generator now follows Article redirects.
 *     version 0.3:
 *         Added Version Notes.
 *         Fixed relative-links bug (all links in item descriptions are now fully qualified).
 *         Fixed date-overwrite bug (previously, items with the exact same timestamp would be ignored).
 *         Improved W3C validation. Feeds validate, but there are still warnings.
 *     version 0.2:
 *         Renamed from WikiFeeds.php to WikiArticleFeeds.php
 *         Corrected credits and copyright info.
 *         Numerous minor fixes and tweaks.
 *         Expanded support for versions 1.6.x, 1.8.x and 1.9.x.
 *         Improved return values from hooking functions (plays better with other extensions).
 *     version 0.1:
 *         Initial release.
 * -----------------------------------------------------------------------
 * Copyright (c) 2007 Jim R. Wilson
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy 
 * of this software and associated documentation files (the "Software"), to deal 
 * in the Software without restriction, including without limitation the rights to 
 * use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of 
 * the Software, and to permit persons to whom the Software is furnished to do 
 * so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in all 
 * copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, 
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES 
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND 
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT 
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, 
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING 
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR 
 * OTHER DEALINGS IN THE SOFTWARE. 
 * -----------------------------------------------------------------------
 */

# Confirm MW environment
if ( !defined( 'MEDIAWIKI' ) ) die();

define( 'WIKIARTICLEFEEDS_VERSION', '0.6.4' );

# Bring in supporting classes
require_once( "$IP/includes/Feed.php" );
require_once( "$IP/includes/Sanitizer.php" );

# Credits
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'WikiArticleFeeds',
	'author' => 'Jim Wilson (wilson.jim.r&lt;at&gt;gmail.com)',
	'url' => 'http://jimbojw.com/wiki/index.php?title=WikiArticleFeeds',
	'description' => 'Produces feeds generated from MediaWiki articles.',
	'descriptionmsg' => 'wikiarticlefeeds-desc',
	'version' => WIKIARTICLEFEEDS_VERSION
);

$dir = dirname( __FILE__ ) . '/';

$wgExtensionMessagesFiles['WikiArticleFeeds'] = $dir . 'WikiArticleFeeds.i18n.php';

/**
 * Wrapper class for consolidating all WAF related parser methods
 */
class WikiArticleFeedsParser {

	function feedStart( $text, $params = array() ) {
		return '<!-- FEED_START -->';
	}

	function feedEnd( $text, $params = array() ) {
		return '<!-- FEED_END -->';
	}

	function burnFeed( $text, $params = array() ) {
		return ( $params['name'] ? '<!-- BURN_FEED ' . base64_encode( serialize( $params['name'] ) ) . ' -->':'' );
	}

	function itemTagsTag( $text, $params = array() ) {
		return ( $text ? '<!-- ITEM_TAGS ' . base64_encode( serialize( $text ) ) . ' -->':'' );
	}

	function itemTagsFunction( $parser ) {
		$tags = func_get_args();
		array_shift( $tags );
		return ( !empty( $tags ) ? '<pre>@ITEMTAGS@' . base64_encode( serialize( implode( ',', $tags ) ) ) . '@ITEMTAGS@</pre>':'' );
	}

	// FIXME: remove after 1.16 branching. This extension has not been branched yet.
	function itemTagsMagic( &$magicWords, $langCode = null ) {
		$magicWords['itemtags'] = array( 0, 'itemtags' );
		return true;
	}

	function itemTagsPlaceholderCorrections( $parser, &$text ) {
		$text = preg_replace(
							 '|<pre>@ITEMTAGS@([0-9a-zA-Z\\+\\/]+=*)@ITEMTAGS@</pre>|',
							 '<!-- ITEM_TAGS $1 -->',
							 $text
							 );
		return true;
	}
}

# Create global instance
$wgWikiArticleFeedsParser = new WikiArticleFeedsParser();
// FIXME: update after 1.16 branching for new style magic words. This extension has not been branched yet.
if ( version_compare( $wgVersion, '1.7', '<' ) ) {
	# Hack solution to resolve 1.6 array parameter nullification for hook args
	function wfWAFParserItemTagsMagic( &$magicWords ) {
		global $wgWikiArticleFeedsParser;
		$wgWikiArticleFeedsParser->itemTagsMagic( $magicWords );
		return true;
	}
	function wfWAFParserPlaceholderCorrections( $parser, &$text ) {
		global $wgWikiArticleFeedsParser;
		$wgWikiArticleFeedsParser->itemTagsPlaceholderCorrections( $parser, $text );
		return true;
	}
	$wgHooks['LanguageGetMagic'][] = 'wfWAFParserItemTagsMagic';
	$wgHooks['ParserBeforeTidy'][] = 'wfWAFParserPlaceholderCorrections';
} else {
	$wgHooks['LanguageGetMagic'][] = array( $wgWikiArticleFeedsParser, 'itemTagsMagic' );
	$wgHooks['ParserBeforeTidy'][] = array( $wgWikiArticleFeedsParser, 'itemTagsPlaceholderCorrections' );
}

# Add Extension Functions
if ( defined( 'MW_SUPPORTS_PARSERFIRSTCALLINIT' ) )
	$wgHooks['ParserFirstCallInit'][] = 'wfWikiArticleFeedsParserSetup';
else
	$wgExtensionFunctions[] = 'wfWikiArticleFeedsParserSetup';

# Sets up the WikiArticleFeeds Parser hooks
function wfWikiArticleFeedsParserSetup() {
	global $wgParser, $wgWikiArticleFeedsParser;

	$wgParser->setHook( 'startFeed', array( $wgWikiArticleFeedsParser, 'feedStart' ) );
	$wgParser->setHook( 'endFeed', array( $wgWikiArticleFeedsParser, 'feedEnd' ) );
	$wgParser->setHook( 'feedBurner', array( $wgWikiArticleFeedsParser, 'burnFeed' ) );
	$wgParser->setHook( 'itemTags', array( $wgWikiArticleFeedsParser, 'itemTagsTag' ) );

	$wgParser->setFunctionHook( 'itemtags', array( $wgWikiArticleFeedsParser, 'itemTagsFunction' ) );
	return true;
}

# Attach Hooks
$wgHooks['OutputPageBeforeHTML'][] = 'wfAddWikiFeedHeaders';
if ( version_compare( $wgVersion, '1.13', '>=' ) ) {
	$wgHooks['SkinTemplateToolboxEnd'][] = 'wfWikiArticleFeedsToolboxLinks'; // introduced in 1.13
} else {
	$wgHooks['MonoBookTemplateToolboxEnd'][] = 'wfWikiArticleFeedsToolboxLinks';
}
$wgHooks['UnknownAction'][] = 'wfWikiArticleFeedsAction';
$wgHooks['ArticlePurge'][] = 'wfPurgeFeedsOnArticlePurge';

/**
 * Adds the Wiki feed link headers.
 * Usage: $wgHooks['OutputPageBeforeHTML'][] = 'wfAddWikiFeedHeaders';
 * @param $out Handle to an OutputPage object (presumably $wgOut).
 * @param $text Article/Output text.
 */
function wfAddWikiFeedHeaders( $out, $text ) {

	# Short-circuit if this article contains no feeds
	if ( !preg_match( '/<!-- FEED_START -->/m', $text ) ) return true;

	$rssArr = array(
					'rel' => 'alternate',
					'type' => 'application/rss+xml',
					'title' => 'RSS 2.0',
					);
	$atomArr = array(
					 'rel' => 'alternate',
					 'type' => 'application/atom+xml',
					 'title' => 'Atom 0.3',
					 );

	# Test for feedBurner presence
	if ( preg_match( '/<!-- BURN_FEED ([0-9a-zA-Z\\+\\/]+=*) -->/m', $text, $matches ) ) {
		$name = @unserialize( @base64_decode( $matches[1] ) );
		if ( $name ) {
			$rssArr['href'] = 'http://feeds.feedburner.com/' . urlencode( $name ) . '?format=xml';
			$atomArr['href'] = 'http://feeds.feedburner.com/' . urlencode( $name ) . '?format=xml';
		}
	}

	# If its not being fed by feedBurner, do it ourselves!
	if ( !array_key_exists( 'href', $rssArr ) || !$rssArr['href'] ) {

		global $wgServer, $wgScript;

		$baseUrl = $wgServer . $wgScript . '?title=' . $out->getTitle()->getDBkey() . '&action=feed&feed=';
		$rssArr['href'] = $baseUrl . 'rss';
		$atomArr['href'] = $baseUrl . 'atom';
	}

	$out->addLink( $rssArr );
	$out->addLink( $atomArr );

	global $wgWikiFeedPresent;
	$wgWikiFeedPresent = true;

	# True to indicate that other action handlers should continue to process this page
	return true;
}

/**
 * Adds the Wiki feed links to the bottom of the toolbox in Monobook or like-minded skins.
 * Usage: $wgHooks['SkinTemplateToolboxEnd'][] = 'wfWikiArticleFeedsToolboxLinks';
 * @param QuickTemplate $template Instance of MonoBookTemplate or other QuickTemplate
 */
function wfWikiArticleFeedsToolboxLinks( $template ) {
	global $wgOut, $wgServer, $wgScript, $wgArticle, $wgWikiFeedPresent;

	# Short-circuit if wgArticle has not been set or there are no Feeds present
	if ( !$wgArticle || !$wgWikiFeedPresent ) return true;

	$result = '<li id="feedlinks">';

	# Test for feedBurner presence
	$burned = false;
	ob_start();
	$template->html( 'bodytext' );
	$text = ob_get_contents();
	ob_end_clean();
	if ( preg_match( '/<!-- BURN_FEED ([0-9a-zA-Z\\+\\/]+=*) -->/m', $text, $matches ) ) {
		$feedBurnerName = @unserialize( @base64_decode( $matches[1] ) );
		if ( $feedBurnerName ) {
			$feeds = array( 'rss' => 'RSS', 'atom' => 'Atom' );
			foreach ( $feeds as $feed => $name ) {
				$result .=
				'<span id="feed-' . htmlspecialchars( $feed ) . '">' .
				'<a href="http://feeds.feedburner.com/' . urlencode( $feedBurnerName ) . '?format=xml">' .
				htmlspecialchars( $name ) . '</a>&nbsp;</span>';
			}
			$burned = true;
		}
	}

	# Generate regular RSS and Atom feeds if not fed by feedBurner
	if ( !$burned ) {
		$title = $wgArticle->getTitle();
		$dbKey = $title->getPrefixedDBkey();
		$baseUrl = $wgServer . $wgScript . '?title=' . $dbKey . '&action=feed&feed=';
		$feeds = array( 'rss' => 'RSS', 'atom' => 'Atom' );
		foreach ( $feeds as $feed => $name ) {
			$result .=
			'<span id="feed-' . htmlspecialchars( $feed ) . '">' .
			'<a href="' . htmlspecialchars( $baseUrl . $feed ) . '">' .
			htmlspecialchars( $name ) . '</a>&nbsp;</span>';
		}
	}

	echo ( $result . '</li>' );

	# True to indicate that other action handlers should continue to process this page
	return true;
}

/**
 * Injects handling of the 'feed' action.
 * Usage: $wgHooks['UnknownAction'][] = 'wfWikiArticleFeedsAction';
 * @param $action Handle to an action string (presumably same as global $action).
 * @param $article Article to be converted to rss or atom feed  (presumably same as $wgArticle).
 */
function wfWikiArticleFeedsAction( $action, $article ) {
	
	# If some other action is in the works, cut and run!
	if ( $action != 'feed' ) return true;

	global $wgOut, $wgRequest, $wgFeedClasses, $wgFeedCacheTimeout, $wgDBname, $messageMemc, $wgSitename;

	# Get query parameters
	$feedFormat = $wgRequest->getVal( 'feed', 'atom' );
	$filterTags = $wgRequest->getVal( 'tags', null );

	# Process requested tags for use in keys
	if ( $filterTags ) {
		$filterTags = explode( ',', $filterTags );
		array_walk( $filterTags, 'trim' );
		sort( $filterTags );
	}

	if ( !isset( $wgFeedClasses[$feedFormat] ) ) {
		wfHttpError( 500, "Internal Server Error", "Unsupported feed type." );
		return false;
	}

	# Setup cache-checking vars
	$title = $article->getTitle();
	$titleDBkey = $title->getPrefixedDBkey();
	$tags = ( is_array( $filterTags ) ? ':' . implode( ',', $filterTags ):'' );
	$key = "{$wgDBname}:wikiarticlefeedsextension:{$titleDBkey}:{$feedFormat}{$tags}";
	$timekey = $key . ":timestamp";
	$cachedFeed = false;
	$feedLastmod = $messageMemc->get( $timekey );

	# Dermine last modification time for either the article itself or an included template
	$lastmod = $article->getTimestamp();
	$templates = $article->getUsedTemplates();
	foreach ( $templates as $tTitle ) {
		$tArticle = new Article( $tTitle );
		$tmod = $tArticle->getTimestamp();
		$lastmod = ( $lastmod > $tmod ? $lastmod:$tmod );
	}

	# Check for availability of existing cached version
	if ( ( $wgFeedCacheTimeout > 0 ) && $feedLastmod ) {
		$feedLastmodTS = wfTimestamp( TS_UNIX, $feedLastmod );
		if (
			time() - $feedLastmodTS < $wgFeedCacheTimeout ||
			$feedLastmodTS > wfTimestamp( TS_UNIX, $lastmod )
			) {
			wfDebug( "WikiArticleFeedsExtension: Loading feed from cache ($key; $feedLastmod; $lastmod)...\n" );
			$cachedFeed = $messageMemc->get( $key );
		} else {
			wfDebug( "WikiArticleFeedsExtension: Cached feed timestamp check failed ($feedLastmod; $lastmod)\n" );
		}
	}

	# Display cachedFeed, or generate one from scratch
	global $wgWikiArticleFeedsSkipCache;
	if ( !$wgWikiArticleFeedsSkipCache && is_string( $cachedFeed ) ) {
		wfDebug( "WikiArticleFeedsExtension: Outputting cached feed\n" );
		$feed = new $wgFeedClasses[$feedFormat]( $wgSitename . ' - ' . $title->getText(), '', $title->getFullURL() );
		$feed->httpHeaders();
		echo $cachedFeed;
	} else {
		wfDebug( "WikiArticleFeedsExtension: Rendering new feed and caching it\n" );
		ob_start();
		wfGenerateWikiFeed( $article, $feedFormat, $filterTags );
		$cachedFeed = ob_get_contents();
		ob_end_flush();
		
		$expire = 3600 * 24; # One day
		$messageMemc->set( $key, $cachedFeed );
		$messageMemc->set( $timekey, wfTimestamp( TS_MW ), $expire );
	}

	# False to indicate that other action handlers should not process this page
	return false;
}

/**
 * Purges all associated feeds when an Article is purged.
 * Usage: $wgHooks['ArticlePurge'][] = 'wfPurgeFeedsOnArticlePurge';
 * @param Article $article The Article which is being purged.
 * @return boolean Always true to permit additional hook processing.
 */
function wfPurgeFeedsOnArticlePurge( $article ) {
	global $messageMemc, $wgDBname;
	$titleDBKey = $article->mTitle->getPrefixedDBkey();
	$keyPrefix = "{$wgDBname}:wikiarticlefeedsextension:{$titleDBKey}";
	$messageMemc->delete( "{$keyPrefix}:atom:timestamp" );
	$messageMemc->delete( "{$keyPrefix}:atom" );
	$messageMemc->delete( "{$keyPrefix}:rss" );
	$messageMemc->delete( "{$keyPrefix}:rss:timestamp" );
	return true;
}

/**
 * Converts an MArticle into a feed, echoing generated content directly.
 * @param Article $article Article to be converted to RSS or Atom feed.
 * @param String $feedFormat A format type - must be either 'rss' or 'atom'
 * @param Array $filterTags Tags to use in filtering out items.
 */
function wfGenerateWikiFeed( $article, $feedFormat = 'atom', $filterTags = null ) {
	global $wgOut, $wgScript, $wgServer, $wgFeedClasses, $wgVersion, $wgSitename;

	# Setup, handle redirects
	if ( $article->isRedirect() ) {
		$rtitle = Title::newFromRedirect( $article->getContent() );
		if ( $rtitle ) {
			$article = new Article( $rtitle );
		}
	}
	$title = $article->getTitle();
	$feedUrl = $title->getFullUrl();

	# Parse page into feed items.
	$content = $wgOut->parse( $article->getContent() . "\n__NOEDITSECTION__ __NOTOC__" );
	preg_match_all(
				   '/<!--\\s*FEED_START\\s*-->(.*?)<!--\\s*FEED_END\\s*-->/s',
				   $content,
				   $matches
				   );
	$feedContentSections = $matches[1];

	# Parse and process all feeds, collecting feed items
	$items = array();
	$feedDescription = '';
	foreach ( $feedContentSections as $feedKey => $feedContent ) {

		# Determine Feed item depth (what header level defines a feed)
		preg_match_all( '/<h(\\d)>/m', $feedContent, $matches );
		if ( empty( $matches[1] ) ) next;
		$lvl = $matches[1][0];
		foreach ( $matches[1] as $match ) {
			if ( $match < $lvl ) $lvl = $match;
		}

		$sectionRegExp = '#<h' . $lvl . '>\s*<span.+?id="(.*?)">\s*(.*?)\s*</span>\s*</h' . $lvl . '>#m';

		# Determine the item titles and default item links
		preg_match_all(
					   $sectionRegExp,
					   $feedContent, 
					   $matches
					   );
		$itemLinks = $matches[1];
		$itemTitles = $matches[2];

		# Split content into segments
		$segments = preg_split( $sectionRegExp, $feedContent );
		$segDesc = trim( strip_tags( array_shift( $segments ) ) );
		if ( $segDesc ) {
			if ( !$feedDescription ) {
				$feedDescription = $segDesc;
			} else {
				wfLoadExtensionMessages( 'WikiArticleFeeds' );
				$feedDescription = wfMsg( 'wikiarticlefeeds_combined_description' );
			}
		}

		# Loop over parsed segments and add all items to item array
		foreach ( $segments as $key => $seg ) {

			# Filter by tag (if any are present)
			$skip = false;
			$tags = null;
			if ( is_array( $filterTags ) && !empty( $filterTags ) ) {
				if ( preg_match_all( '/<!-- ITEM_TAGS ([0-9a-zA-Z\\+\\/]+=*) -->/m', $seg, $matches ) ) {
					$tags = array();
					foreach ( $matches[1] as $encodedString ) {
						$t = @unserialize( @base64_decode( $encodedString ) );
						if ( $t ) {
							$t = explode( ',', $t );
							array_walk( $t, 'trim' );
							sort( $t );
							$tags = array_merge( $tags, $t );
						}
					}
					$tags = array_unique( $tags );
					if ( !count( array_intersect( $tags, $filterTags ) ) ) $skip = true;
					$seg = preg_replace( '/<!-- ITEM_TAGS ([0-9a-zA-Z\\+\\/]+=*) -->/m', '', $seg );
				} else {
					$skip = true;
				}
			}
			if ( $skip ) continue;

			# Determine the item author and date
			$author = null;
			$date = null;
			$signatureRegExp = '#<a href=".+?User:.+?" title="User:.+?">(.*?)</a> (\d\d):(\d\d), (\d+) ([a-z]+) (\d{4}) \([A-Z]+\)#im';
			# Look for a regular ~~~~ sig
			$isAttributable = preg_match($signatureRegExp, $seg, $matches );

			# Parse it out - if we can
			if ( $isAttributable ) {
				list( $author, $hour, $min, $day, $monthName, $year ) = array_slice( $matches, 1 );
				$months = array(
								'January' => '01', 'February' => '02', 'March' => '03', 'April' => '04',
								'May' => '05', 'June' => '06', 'July' => '07', 'August' => '08',
								'September' => '09', 'October' => '10', 'November' => '11', 'December' => '12'
								);
				$month = $months[$monthName];
				$day = str_pad( $day, 2, '0', STR_PAD_LEFT );
				$date = $year . $month . $day . $hour . $min . '00';
			}

			# Set default 'article section' feed-link
			$url = $feedUrl . '#' . $itemLinks[$key];

			# Look for an alternative to the default link (unless default 'section linking' has been forced)
			global $wgForceArticleFeedSectionLinks;
			if ( !$wgForceArticleFeedSectionLinks ) {
				$strippedSeg = preg_replace($signatureRegExp, '', $seg );
				preg_match(
					'#<a [^>]*href=([\'"])(.*?)\\1[^>]*>(.*?)</a>#m',
					$strippedSeg,
					$matches
					);
				if ( $matches[2] ) {
					$url = $matches[2];
					if ( preg_match( '#^/#', $url ) ) {
						$url = $wgServer . $url;
					}
				}
			}

			# Create 'absolutified' segment - where all URLs are fully qualified
			$seg = preg_replace( '/ (href|src)=([\'"])\\//', ' $1=$2' . $wgServer . '/', $seg );

			# Create item and push onto item list
			$items[$date][] = new FeedItem( strip_tags( $itemTitles[$key] ), $seg, $url, $date, $author );
		}
	}

	# Programmatically determine the feed title and id.
	$feedTitle = $wgSitename . ' - ' . $title->getPrefixedText();
	$feedId = $title->getFullUrl();

	# Create feed    
	$feed = new $wgFeedClasses[$feedFormat]( $feedTitle, $feedDescription, $feedId );

	# Push feed header
	$tempWgVersion = $wgVersion;
	$wgVersion .= ' via WikiArticleFeeds ' . WIKIARTICLEFEEDS_VERSION;
	$feed->outHeader();
	$wgVersion = $tempWgVersion;

	# Sort all items by date and push onto feed
	krsort( $items );
	foreach ( $items as $itemGroup ) {
		foreach ( $itemGroup as $item ) {
			$feed->outItem( $item );
		}
	}

	# Feed footer
	$feed->outFooter();
}

