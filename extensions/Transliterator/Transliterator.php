<?php
/**
 * @file
 * @ingroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:Transliterator Documentation
 *
 * @author Conrad Irwin
 * @modifier Purodha Blissenbach
 * @copyright Copyright © 2009,2010 Conrad.Irwin
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0
 * @version 1.4
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, not a valid entry point.' );
}

$wgTransliteratorRuleCount = 500;	// maximum number of permitted rules per map.
$wgTransliteratorRuleSize  =  10;	// maximum number of characters in left side of a rule.

$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Transliterator',
	'version' => '1.4.1',
	'descriptionmsg' => 'transliterator-desc',
	'author' => 'Conrad Irwin',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Transliterator',
	'path' => __FILE__,
);

$wgAutoloadClasses['ExtTransliterator'] = dirname( __FILE__ ) . "/Transliterator_body.php";
$wgExtensionMessagesFiles['Transliterator'] = dirname( __FILE__ ) . '/Transliterator.i18n.php';
$wgExtensionMessagesFiles['TransliteratorMagic'] = dirname( __FILE__ ) . '/Transliterator.i18n.magic.php';
$wgParserTestFiles[] = dirname( __FILE__ ) . '/transliteratorParserTests.txt';

$wgHooks['ParserFirstCallInit'][] = 'ExtTransliterator::setup';
# Purge the cache for as many cases as I can find.
$wgHooks['ArticleDeleteComplete'][]  = 'ExtTransliterator::purgeArticle';
$wgHooks['NewRevisionFromEditComplete'][]  = 'ExtTransliterator::purgeArticleNewRevision';
$wgHooks['ArticlePurge'][]  = 'ExtTransliterator::purgeArticle';
$wgHooks['ArticleUndelete'][]  = 'ExtTransliterator::purgeTitle';
$wgHooks['TitleMoveComplete'][] = 'ExtTransliterator::purgeNewtitle';
# Show error messages when editing the map pages or prefix.
$wgHooks['EditFilter'][] = 'ExtTransliterator::validate';
$wgHooks['EditPageGetPreviewText'][] = 'ExtTransliterator::preview';
