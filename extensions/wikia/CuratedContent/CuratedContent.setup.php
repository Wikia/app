<?php
/**
 * Curated Content API setup file
 */
$dir = dirname( __FILE__ );
/**
 * classes
 */
$wgAutoloadClasses['CuratedContentController'] = "{$dir}/CuratedContentController.class.php";
$wgAutoloadClasses['CuratedContentWrongAPIVersionException'] = "{$dir}/CuratedContentController.class.php";
$wgAutoloadClasses['CuratedContentModel'] =  "{$dir}/CuratedContentModel.class.php" ;
/**
 * message files
 */
$wgExtensionMessagesFiles['CuratedContent'] = "{$dir}/CuratedContent.i18n.php";


//Special Page to preview page in Curated Content style
$wgAutoloadClasses['CuratedContentSpecialPreviewController'] =  "{$dir}/CuratedContentSpecialPreviewController.class.php" ;
$wgSpecialPages['CuratedContentPreview'] = 'CuratedContentSpecialPreviewController';

$wgGroupPermissions['*']['curatedcontentpreview'] = false;
$wgGroupPermissions['staff']['curatedcontentpreview'] = true;
$wgGroupPermissions['sysop']['curatedcontentpreview'] = true;

//Special Page for Content Managment Tool
$wgAutoloadClasses[ 'CuratedContentSpecialController'] =  "{$dir}/CuratedContentSpecialController.class.php" ;
$wgSpecialPages[ 'CuratedContent' ] =  'CuratedContentSpecialController';

$wgGroupPermissions['*']['curatedcontent'] = false;
$wgGroupPermissions['staff']['curatedcontent'] = true;
$wgGroupPermissions['helper']['curatedcontent'] = true;

if ( $wgCuratedContentForAdmins ) {
	$wgGroupPermissions['sysop']['curatedcontent'] = true;
}

$wgGroupPermissions['*']['curatedcontent-switchforadmins'] = false;
$wgGroupPermissions['staff']['curatedcontent-switchforadmins'] = true;

JSMessages::registerPackage( 'CuratedContentMsg', [
	'wikiacuratedcontent-content-duplicate-entry',
	'wikiacuratedcontent-content-required-entry',
	'wikiacuratedcontent-content-empty-section',
	'wikiacuratedcontent-content-item-error',
	'wikiacuratedcontent-content-articlenotfound-error',
	'wikiacuratedcontent-content-emptylabel-error',
	'wikiacuratedcontent-content-videonotsupported-error',
	'wikiacuratedcontent-content-notsupportedtype-error'
] );

//hooks
$wgHooks['CuratedContentSave'][] = 'CuratedContentController::onCuratedContentSave';
//add Curated Content to WikiFeatures
$wgHooks['WikiFeatures::onGetFeatureNormal'][] = 'CuratedContentSpecialController::onWikiFeatures';
$wgHooks['WikiFeatures::onToggleFeature'][] = 'CuratedContentSpecialController::onWikiFeatures';

//minimal package of messages in CuratedContent
JSMessages::registerPackage( 'CuratedContent', [
	'wikiamobile-hide-section',
	'wikiamobile-image-not-loaded',
	'wikiamobile-video-not-friendly',
	'wikiamobile-video-not-friendly-header'
] );
