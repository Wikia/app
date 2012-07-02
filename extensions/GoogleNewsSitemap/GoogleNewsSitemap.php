<?php
if ( !defined( 'MEDIAWIKI' ) ) {
    echo <<<EOT
To install GoogleNewsSitemap extension, an extension special page, put the following line in LocalSettings.php:
require_once( dirname(__FILE__) . '/extensions/GoogleNewsSitemap/GoogleNewsSitemap.php' );
EOT;
    exit( 1 );
}

/**
 * Outputs feed xml
 **
 * A Special Page extension to produce:
 *  Google News sitemap output - http://www.google.com/support/news_pub/bin/answer.py?hl=en&answer=74288
 *      - http://www.sitemaps.org/protocol.php
 *  RSS feed output - 2.0 http://www.rssboard.org/rss-specification
 *                  - 0.92 http://www.rssboard.org/rss-0-9-2
 *  Atom feed output - 2005 http://tools.ietf.org/html/rfc4287
 **
 * This page can be accessed from Special:GoogleNewsSitemap?[categories=Catname]
 *      [&notcategories=OtherCatName][&namespace=0]
 *      [&feed=sitemap][&count=10][&ordermethod=lastedit]
 *      [&order=ascending]
 **
 *  This program is free software; you can redistribute it and/or modify it
 *  under the terms of the GNU General Public License as published by the Free
 *  Software Foundation; either version 2 of the License, or (at your option)
 *  any later version.
 *
 *  This program is distributed in the hope that it will be useful, but WITHOUT
 *  ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 *  FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for
 *  more details.
 *
 *  You should have received a copy of the GNU General Public License along with
 *  this program; if not, write to the Free Software Foundation, Inc., 59 Temple
 *  Place - Suite 330, Boston, MA 02111-1307, USA.
 *  http://www.gnu.org/copyleft/gpl.html
 **
 * Contributors
 *  This script is based on Extension:DynamicPageList (Wikimedia), originally
 *  developed by:
 *      wikt:en:User:Amgine        http://en.wiktionary.org/wiki/User:Amgine
 *      n:en:User:IlyaHaykinson http://en.wikinews.org/wiki/User:IlyaHaykinson
 **
 * FIXME requests
 *  use=Mediawiki:GoogleNewsSitemap_Feedname     Parameter to allow on-site control of feed
 **
 * @addtogroup Extensions
 *
 * @author Amgine <amgine.saewyc@gmail.com>
 * @copyright Copyright © 2009, Amgine
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'GoogleNewsSitemap',
	'author' => array( 'Amgine', '[http://mediawiki.org/wiki/User:Bawolff Brian Wolff]' ),
	'descriptionmsg' => 'googlenewssitemap-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:GoogleNewsSitemap',
	'version' => 1,
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['GoogleNewsSitemap'] = $dir . 'GoogleNewsSitemap.i18n.php';
$wgExtensionMessagesFiles['GoogleNewsSitemapAlias'] = $dir . 'GoogleNewsSitemap.alias.php';
$wgAutoloadClasses['GoogleNewsSitemap'] = $dir . 'GoogleNewsSitemap_body.php';
$wgAutoloadClasses['FeedSMItem'] = $dir . 'FeedSMItem.php';
$wgAutoloadClasses['SitemapFeed'] = $dir . 'SitemapFeed.php';
$wgSpecialPages['GoogleNewsSitemap'] = 'GoogleNewsSitemap';
$wgFeedClasses['sitemap'] = 'SitemapFeed';

// Configuration options:
$wgGNSMmaxCategories = 6;   // Maximum number of categories to look for
$wgGNSMmaxResultCount = 50; // Maximum number of results to allow

// Fallback category if no categories are specified.
$wgGNSMfallbackCategory = 'Published';

// How long to put in squid cache. Note also cached using wgMemc (for 12 hours),
// but the wgMemc entries are checked to see if they are still relevant, where
// the squid cache is not checked. So this should be a small number.
$wgGNSMsmaxage = 1800; // = 30 minutes

// $wgGNSMcommentNamespace can be false to mean do not include a <comments> element in the feeds,
// or it can be true, to mean use the talk page of the relevent page as the comments page
// or it can be a specific namespace number ( or NS_BLAH constant) to denote a specific namespace.
// For example, on many Wikinews sites, the comment namespace is Comments (102), not talk.
$wgGNSMcommentNamespace = true;

