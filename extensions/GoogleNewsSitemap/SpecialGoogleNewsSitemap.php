<?php
if (!defined('MEDIAWIKI')) {
    echo <<<EOT
To install GoogleNewsSitemap extension, an extension special page, put the following line in LocalSettings.php:
require_once( dirname(__FILE__) . '/extensions/GoogleNewsSitemap/SpecialGoogleNewsSitemap.php' );
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
 * This page can be accessed from Special:GoogleNewsSitemap[/][|category=Catname]
 *      [|notcategory=OtherCatName][|namespace=0][|notnamespace=User]
 *      [|feed=sitemap][|count=10][|mode=ul][|ordermethod=lastedit]
 *      [|order=ascending] as well as being included like
 *      {{Special:GoogleNewsSitemap/[options][...]}}
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
	'author' => 'Amgine',
	'description' => 'Outputs xml based on defined criteria',
	'descriptionmsg' => 'gnsm-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:GoogleNewsSitemap',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['GoogleNewsSitemap'] = $dir . 'SpecialGoogleNewsSitemap.i18n.php';
$wgExtensionAliasesFiles['GoogleNewsSitemap'] = $dir . 'SpecialGoogleNewsSitemap.alias.php';
$wgAutoloadClasses['GoogleNewsSitemap'] = $dir . 'SpecialGoogleNewsSitemap_body.php';
$wgSpecialPages['GoogleNewsSitemap'] = 'GoogleNewsSitemap';
