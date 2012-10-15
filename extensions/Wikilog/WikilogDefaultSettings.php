<?php
/**
 * MediaWiki Wikilog extension
 * Copyright © 2008-2010 Juliano F. Ravasi
 * http://www.mediawiki.org/wiki/Extension:Wikilog
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 */

/**
 * @file
 * @ingroup Extensions
 * @author Juliano F. Ravasi < dev juliano info >
 */

if ( !defined( 'MEDIAWIKI' ) )
	die();

/**
 *              --- DO NOT MAKE CHANGES TO THESE VALUES ---
 *
 * In order to configure the extension, copy the variables you want to change
 * to your LocalSettings.php file, and change them there, not here.
 */

/* *** Tagging entity *** */

/**
 * A string in the format "example.org,date", according to RFC 4151, that will
 * be used as taggingEntity in order to create feed item tags.
 */
$wgTaggingEntity = false;

/* *** Cascading style sheets *** */

/**
 * Path of Wikilog style and image files.
 * Defaults to "$wgScriptPath/extensions/Wikilog/style".
 */
$wgWikilogStylePath = false;

/**
 * Wikilog style version, incremented when $wgWikilogStylePath/wikilog.css
 * is changed.
 */
$wgWikilogStyleVersion = 6;

/* *** Presentation options *** */

/**
 * Maximum number of articles to display in wikilog front pages, or comments
 * in article discussion pages.
 *
 * Each article and comment is stored as a wiki page and, in order to
 * display them, they may need to be parsed (if they are not cached) which
 * is a little expensive. So, the number of articles or comments to show
 * per page is limited by this variable, which has the same purpose of
 * $wgFeedLimit and thus inherits its value by default.
 *
 * A good value is 50. More than this not only impacts performance, it
 * allows long pages of articles or comments that has little value over
 * smaller pages.
 *
 * @note This variable replaced the older $wgWikilogSummaryLimit.
 * @since Wikilog v1.1.0.
 */
$wgWikilogExpensiveLimit = $wgFeedLimit;

/**
 * Default number of articles to list in the wikilog front page and in
 * Special:Wikilog.
 */
$wgWikilogNumArticles = 20;

/**
 * Default number of comments to list in wikilog comment pages.
 * @since Wikilog v1.1.0.
 */
$wgWikilogNumComments = 50;

/**
 * Allow listing of categories and tags for each article in the wikilog
 * front page and in Special:Wikilog, in the header and footer of each entry.
 * This is a little expensive and not used by default, so it is disabled.
 *
 * After enabling this option, system messages 'wikilog-summary-header',
 * 'wikilog-summary-footer', 'wikilog-summary-header-single' and
 * 'wikilog-summary-footer-single' should be modified to include parameters
 * $11 - $14.
 *
 * @since Wikilog v1.1.0.
 */
$wgWikilogExtSummaries = false;

/* *** Editing *** */

/**
 * Publish new articles by default. When creating new wikilog articles,
 * if this variable is set to true, the default value of the "Sign and
 * publish this article" checkbox will be checked, which means that saving
 * the article will automatically sign and publish it. In order to save
 * the article as draft, the user would have to uncheck the box before
 * saving.
 * @since Wikilog v1.0.1.
 */
$wgWikilogSignAndPublishDefault = false;

/* *** Authors *** */

/**
 * Maximum number of authors of a wikilog article.
 */
$wgWikilogMaxAuthors = 6;

/* *** Categories and tags *** */

/**
 * Enable use of tags. This is disabled by default since MediaWiki category
 * system already provides similar functionality, and are the preferred way
 * of organizing wikilog posts. Enable this if you want or need an additional
 * mechanism for organizing that is independent from categories, and specific
 * for wikilog posts.
 *
 * Even if disabled, tags are still recorded. This configuration only affects
 * the ability of performing queries based on tags. This is so that it could
 * be enabled and disabled without having to perform maintenance on the
 * database.
 */
$wgWikilogEnableTags = false;

/**
 * Maximum number of tags in a wikilog post.
 */
$wgWikilogMaxTags = 25;

/* *** Comments *** */

/**
 * Enable wikilog article commenting interface. When disabled, commenting is
 * still possible through article talk pages, like normal wiki pages.
 */
$wgWikilogEnableComments = true;

/**
 * Maximum size for wikilog article comments, in bytes.
 */
$wgWikilogMaxCommentSize = 2048;	// bytes

/**
 * Moderation options for comments. When set to true, new comments by anonymous
 * users will be placed in a pending state until someone with 'wl-moderation'
 * right approves it.
 *
 * @note No option of moderation for logged-in users is provided, it doesn't
 * make a lot of sense for a wiki. If this is your case, check if what you
 * need isn't better accomplished with user rights or anti-spam filters.
 */
$wgWikilogModerateAnonymous = false;

/* *** Syndication feeds *** */

/**
 * Syndication feed classes. Similar to $wgFeedClasses.
 */
$wgWikilogFeedClasses = array(
	'atom' => 'WlAtomFeed',
	'rss'  => 'WlRSSFeed'
);

/**
 * Enable or disable output of summary or content in wikilog feeds. At least
 * one of them MUST be true.
 */
$wgWikilogFeedSummary = true;
$wgWikilogFeedContent = true;

/**
 * Enable output of article categories in wikilog feeds.
 */
$wgWikilogFeedCategories = true;

/**
 * Enable output of external references in wikilog feeds.
 */
$wgWikilogFeedRelated = false;

/* *** Namespaces *** */

/**
 * Namespaces used for wikilogs.
 */
$wgWikilogNamespaces = array();

/* *** Debugging *** */

/**
 * Use a clone of the global parser object instead of creating a new instance.
 *
 * Optimally this setting would be disabled by default, since the parser is
 * not designed to be cloned. Such usage may cause problems. But there are
 * many broken extensions that don't properly initialize a second parser
 * instance that is needed for parsing articles for syndication feeds. The
 * default is to clone since this seems to work better.
 */
$wgWikilogCloneParser = true;
