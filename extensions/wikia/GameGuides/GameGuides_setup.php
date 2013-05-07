<?php
/**
 * Game Guides API setup file
 * 
 * @author Federico "Lox" Lucignano
 */
$dir = dirname( __FILE__ );

/**
 * classes
 */
$wgAutoloadClassesp['GameGuidesController'] = "{$dir}/GameGuidesController.class.php";
$wgAutoloadClassesp['GameGuidesWrongAPIVersionException'] = "{$dir}/GameGuidesController.class.php";
$wgAutoloadClasses[ 'GameGuidesModel'] =  "{$dir}/GameGuidesModel.class.php" ;

/**
 * message files
 */
$wgExtensionMessagesFiles['GameGuides'] = "{$dir}/GameGuides.i18n.php";


//Special Page to preview page in GameGuide style
$wgAutoloadClasses[ 'GameGuidesSpecialPreviewController'] =  "{$dir}/GameGuidesSpecialPreviewController.class.php" ;
$wgSpecialPages[ 'GameGuidesSpecialPreviewController' ] =  'GameGuidesPreview';

$wgGroupPermissions['*']['gameguidespreview'] = false;
$wgGroupPermissions['staff']['gameguidespreview'] = true;
$wgGroupPermissions['sysop']['gameguidespreview'] = true;

//Special Page for Content Managment Tool
$wgAutoloadClasses[ 'GameGuidesSpecialContentController'] =  "{$dir}/GameGuidesSpecialContentController.class.php" ;
$wgSpecialPages[ 'GameGuidesContent' ] =  'GameGuidesSpecialContentController';

$wgGroupPermissions['*']['gameguidescontent'] = false;
$wgGroupPermissions['staff']['gameguidescontent'] = true;

if ( $wgGameGuidesContentForAdmins ) {
	$wgGroupPermissions['sysop']['gameguidescontent'] = true;
}

$wgGroupPermissions['*']['gameguidescontent-switchforadmins'] = false;
$wgGroupPermissions['staff']['gameguidescontent-switchforadmins'] = true;

JSMessages::registerPackage( 'GameGuidesContentMsg', [
	'wikiagameguides-content-category',
	'wikiagameguides-content-tag',
	'wikiagameguides-content-name',
	'wikiagameguides-content-duplicate-entry',
	'wikiagameguides-content-category-error',
	'wikiagameguides-content-required-entry',
	'wikiagameguides-content-empty-tag'
] );

//hooks
$wgHooks['GameGuidesContentSave'][] = 'GameGuidesController::onGameGuidesContentSave';
$wgHooks['TitleGetSquidURLs'][] = 'GameGuidesController::onTitleGetSquidURLs';
//add Game Guides Content to WikiFeatures
$wgHooks['WikiFeatures::onGetFeatureNormal'][] = 'GameGuidesSpecialContentController::onWikiFeatures';
$wgHooks['WikiFeatures::onToggleFeature'][] = 'GameGuidesSpecialContentController::onWikiFeatures';

//minimal package of messages in Game Gudes
JSMessages::registerPackage( 'GameGuides', array(
	'wikiamobile-hide-section',
	'wikiamobile-image-not-loaded',
	'wikiamobile-video-not-friendly',
	'wikiamobile-video-not-friendly-header'
) );