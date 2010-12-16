<?php
/**
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:Transliterator Documentation
 *
 * @author Conrad Irwin
 * @modifier Purodha Blissenbach
 * @copyright Copyright © 2009 Conrad.Irwin
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0
 *     or later
 * @version 1.0
 *     initial creation.
 * @version 1.0.1
 *     better i18n support, adjustable limits, minor formal adjustment.
 * @version 1.1.0
 *     addition of answer parameter
 * @version 1.2.0
 *     semi-case-sensitive by default, fix bugs with edge-detection and html-entities
 * @version 1.2.1
 *     added cache support
 * @version 1.2.2
 *     use new magic word i18n system
 * @version 1.3.1
 *     made ^ act more like $ (i.e. ^μπ => doesn't prevent μ => from matching), fix bug with cache refresh
 * @version 1.3.2 
 *     cache getExistingMapNames query - still not sure caching is optimal.
 * @version 1.3.3
 *     check prefix length, minor bug with very decomposed characters
 */

/**
	Extension:Transliterator Copyright (C) 2009 Conrad.Irwin

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA
*/

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, not a valid entry point.' );
}

// adjustable parameters
$wgTransliteratorRuleCount = 255;	// maximum number of permitted rules per map.
$wgTransliteratorRuleSize  =  10;	// maximum number of characters in left side of a rule.

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Transliterator',
	'version' => '1.2.2',
	'descriptionmsg' => 'transliterator-desc',
	'author' => 'Conrad Irwin',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Transliterator',
	'path' => __FILE__,
);

$wgAutoloadClasses['ExtTransliterator'] = dirname( __FILE__ ) . "/Transliterator_body.php";
$wgExtensionMessagesFiles['Transliterator'] = dirname(__FILE__) . '/Transliterator.i18n.php';

$wgHooks['ParserFirstCallInit'][] = 'ExtTransliterator::setup';
$wgHooks['ArticleDeleteComplete'][]  = 'ExtTransliterator::purgeArticle';
$wgHooks['NewRevisionFromEditComplete'][]  = 'ExtTransliterator::purgeArticle';
$wgHooks['ArticlePurge'][]  = 'ExtTransliterator::purgeArticle';
$wgHooks['ArticleUndelete'][]  = 'ExtTransliterator::purgeTitle';
$wgHooks['TitleMoveComplete'][] = 'ExtTransliterator::purgeNewtitle';
