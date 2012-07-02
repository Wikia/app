<?php
/**
 * Proof of Concept for Yuvi Panda's 2011 GSoC
 *
 * @file
 * @ingroup Extensions
 * @author Yuvi Panda, http://yuvi.in
 * @copyright © 2011 Yuvaraj Pandian (yuvipanda@yuvi.in)
 * @licence Modified BSD License
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'SelectionSifter',
	'author' => 'Yuvi Panda',
	'url' => 'https://www.mediawiki.org/wiki/Extension:SelectionSifter',
	# 'version' => '0.1',
	'descriptionmsg' => 'selectionsifter-desc',
);

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';

$wgExtensionMessagesFiles['SelectionSifter'] = $dir . 'SelectionSifter.i18n.php';
$wgExtensionMessagesFiles['SelectionSifterAlias'] = $dir . 'SelectionSifter.alias.php';
$wgExtensionMessagesFiles['SelectionSifterMagic'] = $dir . 'SelectionSifter.i18n.magic.php';

$wgAutoloadClasses['SelectionSifterHooks'] = $dir . 'SelectionSifter.hooks.php';
$wgAutoloadClasses['Statistics'] = $dir . 'models/Statistics.php';
$wgAutoloadClasses['Rating'] = $dir . 'models/Rating.php';
$wgAutoloadClasses['AssessmentChangeLog'] = $dir . 'models/Log.php';
$wgAutoloadClasses['Selection'] = $dir . 'models/Selection.php';
$wgAutoloadClasses['TableDisplay'] = $dir . 'TableDisplay.php';
$wgAutoloadClasses['AssessmentsExtractor'] = $dir . 'AssessmentsExtractor.php';
$wgAutoloadClasses['SpecialAssessmentLog'] = $dir . 'SpecialAssessmentLog.php';
$wgAutoloadClasses['SpecialFilterRatings'] = $dir . 'SpecialFilterRatings.php';
$wgAutoloadClasses['SpecialSelection'] = $dir . 'SpecialSelection.php';

$wgAutoloadClasses['FilterRatingsTemplate'] = $dir . 'templates/FilterRatingsTemplate.php';
$wgAutoloadClasses['SelectionTemplate'] = $dir . 'templates/SelectionTemplate.php';

$wgHooks['ArticleSaveComplete'][] = 'SelectionSifterHooks::ArticleSaveComplete';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'SelectionSifterHooks::SetupSchema';

$wgHooks['ParserFirstCallInit'][] = 'TableDisplay::ParserFunctionInit';

$wgHooks['TitleMoveComplete'][] = 'SelectionSifterHooks::TitleMoveComplete';

$wgSpecialPages['AssessmentLog'] = 'SpecialAssessmentLog';
$wgSpecialPages['FilterRatings'] = 'SpecialFilterRatings';
$wgSpecialPages['Selection'] = 'SpecialSelection';

// Configuration
