<?php

/**
 * VideoPageTool
 * @author Garth Webb, Kenneth Kouot, Liz Lee, Saipetch Kongkatong
 */

$wgExtensionCredits['specialpage'][] = array(
	'name'   => 'VideoPageTool',
	'author' => array( 'Garth Webb', 'Kenneth Kouot', 'Liz Lee', 'Saipetch Kongkatong' ),
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/VideoPageTool',
	'descriptionmsg' => 'videopagetool-desc'
);

$dir = dirname(__FILE__) . '/';

// VideoPageTool shared classes
$wgAutoloadClasses['VideoPageToolProgram']       =  $dir . 'model/VideoPageToolProgram.class.php';
$wgAutoloadClasses['VideoPageToolAsset']         =  $dir . 'model/VideoPageToolAsset.class.php';
$wgAutoloadClasses['VideoPageToolAssetFeatured'] =  $dir . 'model/VideoPageToolAssetFeatured.class.php';
$wgAutoloadClasses['VideoPageToolAssetCategory'] =  $dir . 'model/VideoPageToolAssetCategory.class.php';
$wgAutoloadClasses['VideoPageToolAssetFan']      =  $dir . 'model/VideoPageToolAssetFan.class.php';
$wgAutoloadClasses['VideoPageToolHelper']        =  $dir . 'VideoPageToolHelper.class.php';
$wgAutoloadClasses['VideoPageToolHooks']         =  $dir . 'VideoPageToolHooks.class.php';

// VideoPageAdmin classes
$wgAutoloadClasses['VideoPageAdminSpecialController'] = $dir.'VideoPageAdminSpecialController.class.php';

// VideoHomePage classes
$wgAutoloadClasses['VideoHomePageController'] =  $dir . 'VideoHomePageController.class.php';
$wgAutoloadClasses['VideoHomePageArticle']    =  $dir . 'model/VideoHomePageArticle.class.php';
$wgAutoloadClasses['VideoHomePagePage']       =  $dir . 'model/VideoHomePagePage.class.php';

// i18n mapping
$wgExtensionMessagesFiles['VideoPageTool'] = $dir.'VideoPageTool.i18n.php';

// special pages
$wgSpecialPages['VideoPageAdmin'] = 'VideoPageAdminSpecialController';

// hooks
$wgHooks['ArticleFromTitle'][] = 'VideoPageToolHooks::onArticleFromTitle';
$wgHooks['ArticlePurge'][] = 'VideoPageToolHooks::onArticlePurge';
$wgHooks['CategorySelectSave'][] = 'VideoPageToolHooks::onCategorySelectSave';
$wgHooks['VideoIngestionComplete'][] = 'VideoPageToolHooks::onVideoIngestionComplete';
$wgHooks['FileDeleteComplete'][] = 'VideoPageToolHooks::onFileDeleteComplete';

// register messages package for JS
JSMessages::registerPackage('VideoPageTool', array(
	'htmlform-required',
	'videopagetool-confirm-clear-title',
	'videopagetool-confirm-clear-message',
	'videopagetool-description-maxlength-error',
	'videopagetool-video-title-default-text',
	'videopagetool-image-title-default-text',
	'videopagetool-formerror-videokey',
	'videopagetool-formerror-altthumb',
	'videopagetool-formerror-category-name',
));
