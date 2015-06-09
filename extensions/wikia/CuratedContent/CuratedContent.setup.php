<?php
/**
 * Curated Content API setup file
 */
 
$wgExtensionCredits[ 'specialpage' ][ ] = array(
	'name' => 'CuratedContent',
	'author' => 'Wikia',
	'descriptionmsg' => 'wikiacuratedcontent-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CuratedContent',
);

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
$wgExtensionMessagesFiles['CuratedContentAlias'] = "{$dir}/CuratedContent.alias.php";

//Special Page for Content Managment Tool
$wgAutoloadClasses[ 'CuratedContentSpecialController'] =  "{$dir}/CuratedContentSpecialController.class.php" ;
$wgSpecialPages[ 'CuratedContent' ] =  'CuratedContentSpecialController';

$wgGroupPermissions['*']['curatedcontent'] = false;
$wgGroupPermissions['staff']['curatedcontent'] = true;
$wgGroupPermissions['helper']['curatedcontent'] = true;
$wgGroupPermissions['sysop']['curatedcontent'] = true;


$wgGroupPermissions['*']['curatedcontent-switchforadmins'] = false;
$wgGroupPermissions['staff']['curatedcontent-switchforadmins'] = true;

JSMessages::registerPackage( 'CuratedContentMsg', [
	'wikiacuratedcontent-content-duplicate-entry',
	'wikiacuratedcontent-content-required-entry',
	'wikiacuratedcontent-content-empty-section',
	'wikiacuratedcontent-content-orphaned-error',
	'wikiacuratedcontent-content-articlenotfound-error',
	'wikiacuratedcontent-content-emptylabel-error',
	'wikiacuratedcontent-content-videonotsupported-error',
	'wikiacuratedcontent-content-notsupportedtype-error',
	'wikiacuratedcontent-content-nocategoryintag-error',
] );

//hooks
$wgHooks['CuratedContentSave'][] = 'CuratedContentController::onCuratedContentSave';

//minimal package of messages in CuratedContent
JSMessages::registerPackage( 'CuratedContent', [
	'wikiamobile-hide-section',
	'wikiamobile-image-not-loaded',
	'wikiamobile-video-not-friendly',
	'wikiamobile-video-not-friendly-header'
] );
