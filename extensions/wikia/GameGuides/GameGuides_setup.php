<?php
/**
 * Game Guides API setup file
 * 
 * @author Federico "Lox" Lucignano
 */
$dir = dirname( __FILE__ );
$app = F::app();

/**
 * classes
 */
$app->registerClass(
	array(
		'GameGuidesController',
		'GameGuidesWrongAPIVersionException'
	),
	"{$dir}/GameGuidesController.class.php"
);

$app->registerClass( 'GameGuidesModel', "{$dir}/GameGuidesModel.class.php" );

/**
 * message files
 */
$app->registerExtensionMessageFile('GameGuides', "{$dir}/GameGuides.i18n.php");


//Special Page to preview page in GameGuide style
$app->registerClass( 'GameGuidesSpecialPreviewController', "{$dir}/GameGuidesSpecialPreviewController.class.php" );
$app->registerSpecialPage( 'GameGuidesPreview', 'GameGuidesSpecialPreviewController' );

$wgGroupPermissions['*']['gameguidespreview'] = false;
$wgGroupPermissions['staff']['gameguidespreview'] = true;
$wgGroupPermissions['sysop']['gameguidespreview'] = true;

//Special Page for Content Managment Tool
$app->registerClass( 'GameGuidesSpecialContentController', "{$dir}/GameGuidesSpecialContentController.class.php" );
$app->registerSpecialPage( 'GameGuidesContent', 'GameGuidesSpecialContentController' );

$wgGroupPermissions['*']['gameguidescontent'] = false;
$wgGroupPermissions['staff']['gameguidescontent'] = true;

if ( $app->wg->GameGuidesContentForAdmins ) {
	$wgGroupPermissions['sysop']['gameguidescontent'] = true;
}

$wgGroupPermissions['*']['gameguidescontent-switchforadmins'] = false;
$wgGroupPermissions['staff']['gameguidescontent-switchforadmins'] = true;

F::build( 'JSMessages' )->registerPackage( 'GameGuidesContentMsg', [
	'wikiagameguides-content-category',
	'wikiagameguides-content-tag',
	'wikiagameguides-content-name',
	'wikiagameguides-content-duplicate-entry',
	'wikiagameguides-content-category-error',
	'wikiagameguides-content-required-entry',
	'wikiagameguides-content-empty-tag'
] );

//Special Page for Sponsored Videos Managment Tool
$app->registerClass( 'GameGuidesSpecialSponsoredController', "{$dir}/GameGuidesSpecialSponsoredController.class.php" );
$app->registerSpecialPage( 'GameGuidesSponsored', 'GameGuidesSpecialSponsoredController' );

$wgGroupPermissions['*']['gameguidessponsored'] = false;
$wgGroupPermissions['staff']['gameguidessponsored'] = true;

F::build( 'JSMessages' )->registerPackage( 'GameGuidesSponsoredMsg', [
	'wikiagameguides-sponsored-video',
	'wikiagameguides-sponsored-language',
	'wikiagameguides-sponsored-video-title',
	'wikiagameguides-sponsored-duplicate-entry',
	'wikiagameguides-sponsored-required-entry',
	'wikiagameguides-sponsored-empty-language',
	'wikiagameguides-sponsored-orphaned-video',
	'wikiagameguides-sponsored-are-you-sure'
] );

//hooks
$app->registerHook( 'GameGuidesContentSave', 'GameGuidesController', 'onGameGuidesContentSave' );
$app->registerHook( 'GameGuidesSponsoredSave', 'GameGuidesController', 'onGameGuidesSponsoredSave' );
$app->registerHook( 'TitleGetSquidURLs', 'GameGuidesController', 'onTitleGetSquidURLs' );
//add Game Guides Content to WikiFeatures
$app->registerHook( 'WikiFeatures::onGetFeatureNormal', 'GameGuidesSpecialContentController', 'onWikiFeatures' );
$app->registerHook( 'WikiFeatures::onToggleFeature', 'GameGuidesSpecialContentController', 'onWikiFeatures' );

//minimal package of messages in Game Gudes
F::build( 'JSMessages' )->registerPackage( 'GameGuides', array(
	'wikiamobile-hide-section',
	'wikiamobile-image-not-loaded',
	'wikiamobile-video-not-friendly',
	'wikiamobile-video-not-friendly-header'
) );