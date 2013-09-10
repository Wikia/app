<?php

/**
 * VideoPageTool
 * @author Garth Webb, Kenneth Kouot, Liz Lee, Saipetch Kongkatong
 */

$wgExtensionCredits['specialpage'][] = array(
	'name'   => 'VideoPageTool',
	'author' => array( 'Garth Webb', 'Kenneth Kouot', 'Liz Lee', 'Saipetch Kongkatong' )
);

$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses['VideoPageToolSpecialController'] = $dir.'VideoPageToolSpecialController.class.php';
$wgAutoloadClasses['VideoPageController'] =  $dir . 'VideoPageController.class.php';
$wgAutoloadClasses['VideoPageToolHelper'] =  $dir . 'VideoPageToolHelper.class.php';
$wgAutoloadClasses['VideoPageTool'] =  $dir . 'VideoPageTool.class.php';
$wgAutoloadClasses['VideoPageToolFeatured'] =  $dir . 'VideoPageToolFeatured.class.php';
$wgAutoloadClasses['VideoPageToolHooks'] =  $dir . 'VideoPageToolHooks.class.php';
$wgAutoloadClasses['VideoPageArticle'] =  $dir . 'VideoPageArticle.class.php';
$wgAutoloadClasses['VideoPagePage'] =  $dir . 'VideoPagePage.class.php';

// i18n mapping
$wgExtensionMessagesFiles['VideoPageTool'] = $dir.'VideoPageTool.i18n.php';

// special pages
$wgSpecialPages['VideoPageTool'] = 'VideoPageToolSpecialController';

// hooks
$wgHooks['ArticleFromTitle'][] = 'VideoPageToolHooks::onArticleFromTitle';

// permissions
$wgGroupPermissions['*']['videopagetool'] = false;
$wgGroupPermissions['staff']['videopagetool'] = true;
$wgGroupPermissions['sysop']['videopagetool'] = true;
$wgGroupPermissions['helper']['videopagetool'] = true;
$wgGroupPermissions['vstf']['videopagetool'] = true;

// register messages package for JS
JSMessages::registerPackage('VideoPageTool', array(
	'htmlform-required',
	'videopagetool-confirm-clear-title',
	'videopagetool-confirm-clear-message',
	'videopagetool-description-minlength-error',
	'videopagetool-video-title-default-text',
));

