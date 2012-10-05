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

F::build( 'JSMessages' )->registerPackage( 'GameGuidesContentMsg', array(
	'wikiagameguides-content-category',
	'wikiagameguides-content-tag',
	'wikiagameguides-content-name',
	'wikiagameguides-content-duplicate-entry',
	'wikiagameguides-content-category-error'
) );

//hooks
$app->registerHook( 'GameGuidesContentSave', 'GameGuidesController', 'onGameGuidesContentSave' );


//the only globals needed in Game Guides
if ( empty( $app->wg->GameGuidesGlobalsWhiteList ) ) {
$app->wg->set( 'wgGameGuidesGlobalsWhiteList',
	array(
		'wgNamespaceNumber',
		'wgCityId',
		'wgPageName',
		'wgArticleId',
		'wgArticlePath',
		'wgTitle',
		'wgServer',
		'wgScriptPath',
		'wgAssetsManagerQuery',
		'wgStyleVersion'
	) );
}

//minimal package of messages in Game Gudes
F::build( 'JSMessages' )->registerPackage( 'GameGuides', array(
	'wikiamobile-hide-section',
	'wikiamobile-image-not-loaded'
) );