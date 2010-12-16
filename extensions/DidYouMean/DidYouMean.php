<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

require_once( 'DYMNorm.php' );

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'DidYouMean',
	'author'         => array( 'hippietrail (Andrew Dunbar)', 'Chad Horohoe' ),
	'url'            => 'http://www.mediawiki.org/wiki/Extension:DidYouMean',
	'descriptionmsg' => 'didyoumean-desc',
);
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['DidYouMean'] =  $dir . 'DidYouMean.i18n.php';
$wgAutoloadClasses['DidYouMeanHooks'] = $dir . 'DidYouMean.hooks.php';
$wgAutoloadClasses['DidYouMean'] = $dir . 'DidYouMean_body.php';

# do database lookup from these
$wgHooks['ArticleNoArticleText'][] = 'DidYouMeanHooks::articleNoArticleText';
$wgHooks['SpecialSearchResults'][] = 'DidYouMeanHooks::specialSearchNoResults';
$wgHooks['SpecialSearchNoResults'][] = 'DidYouMeanHooks::specialSearchNoResults';

# db lookup + parse existing {{see}} and add enhanced one with db results
$wgHooks['ParserBeforeStrip'][] = 'DidYouMeanHooks::parserBeforeStrip';

# handle delete
$wgHooks['ArticleDelete'][] = 'DidYouMeanHooks::articleDelete';

# handle move
$wgHooks['TitleMoveComplete'][] = 'DidYouMeanHooks::titleMoveComplete';

# handle create / edit
$wgHooks['AlternateEdit'][] = 'DidYouMeanHooks::alternateEdit';
$wgHooks['ArticleSaveComplete'][] = 'DidYouMeanHooks::articleSaveComplete';

# handle undelete
$wgHooks['ArticleUndelete'][] = 'DidYouMeanHooks::articleUndelete';

# handle parser test setup
$wgHooks['ParserTestTables'][] = 'DidYouMeanHooks::parserTestTables';

# set this in LocalSettings.php
$wgDymUseSeeTemplate = false;
