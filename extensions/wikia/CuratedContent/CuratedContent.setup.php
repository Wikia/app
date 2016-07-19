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

/**
 * classes
 */
$wgAutoloadClasses['CuratedContentHelper'] = __DIR__ . '/CuratedContentHelper.class.php';
$wgAutoloadClasses['CuratedContentValidator'] = __DIR__ . '/CuratedContentValidator.class.php';
$wgAutoloadClasses['CuratedContentSpecialPageValidator'] = __DIR__ . '/CuratedContentSpecialPageValidator.class.php';
$wgAutoloadClasses['CuratedContentValidatorController'] = __DIR__ . '/CuratedContentValidatorController.class.php';
$wgAutoloadClasses['CuratedContentController'] = __DIR__ . '/CuratedContentController.class.php';
$wgAutoloadClasses['CuratedContentWrongAPIVersionException'] = __DIR__ . '/CuratedContentController.class.php';
$wgAutoloadClasses['CuratedContentModel'] =  __DIR__ . '/CuratedContentModel.class.php' ;
$wgAutoloadClasses['CuratedContentHooks'] =  __DIR__ . '/CuratedContentHooks.class.php' ;

/**
 * message files
 */
$wgExtensionMessagesFiles['CuratedContent'] = __DIR__ . '/CuratedContent.i18n.php';
$wgExtensionMessagesFiles['CuratedContentAlias'] = __DIR__ . '/CuratedContent.alias.php';

// Special Page for Content Managment Tool
$wgAutoloadClasses[ 'CuratedContentSpecialController'] =  __DIR__ . '/CuratedContentSpecialController.class.php' ;
$wgSpecialPages[ 'CuratedContent' ] =  'CuratedContentSpecialController';

JSMessages::registerPackage( 'CuratedContentMsg', [
	'wikiacuratedcontent-content-duplicate-entry',
	'wikiacuratedcontent-content-required-entry',
	'wikiacuratedcontent-content-empty-section',
	'wikiacuratedcontent-content-orphaned-error',
	'wikiacuratedcontent-content-articlenotfound-error',
	'wikiacuratedcontent-content-emptylabel-error',
	'wikiacuratedcontent-content-toolonglabel-error',
	'wikiacuratedcontent-content-videonotsupported-error',
	'wikiacuratedcontent-content-notsupportedtype-error',
	'wikiacuratedcontent-content-nocategoryintag-error',
	'wikiacuratedcontent-content-imagemissing-error'
] );

// hooks
$wgHooks['CuratedContentSave'][] = 'CuratedContentHooks::onCuratedContentSave';
$wgHooks['SkinAfterBottomScripts'][] = 'CuratedContentHooks::onSkinAfterBottomScripts';
$wgHooks['OutputPageBeforeHTML'][] = 'CuratedContentHooks::onOutputPageBeforeHTML';

// minimal package of messages in CuratedContent
JSMessages::registerPackage( 'CuratedContent', [
	'wikiamobile-hide-section',
	'wikiamobile-image-not-loaded',
	'wikiamobile-video-not-friendly',
	'wikiamobile-video-not-friendly-header'

] );

JSMessages::registerPackage( 'CuratedContentModal', [
	'wikiacuratedcontent-close-modal-prompt-message',
	'wikiacuratedcontent-modal-title'
] );
