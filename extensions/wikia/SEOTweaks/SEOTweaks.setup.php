<?php
/**
 * SEOTweaks setup
 *
 * @author mech
 * @author ADi
 * @author Jacek Jursza <jacek at wikia-inc.com>
 *
 */
$dir = dirname(__FILE__) . '/';

//classes
$wgAutoloadClasses['SEOTweaksHooksHelper'] =  $dir . 'SEOTweaksHooksHelper.class.php';

// hooks
$wgHooks['ArticleRobotPolicy'][] = 'SEOTweaksHooksHelper::onArticleRobotPolicy';
$wgHooks['ArticleViewHeader'][] = 'SEOTweaksHooksHelper::onArticleViewHeader';
$wgHooks['BeforeParserMakeImageLinkObjOptions'][] = 'SEOTweaksHooksHelper::onBeforeParserMakeImageLinkObjOptions';
$wgHooks['CategoryPageView'][] = 'SEOTweaksHooksHelper::onCategoryPageView';
$wgHooks['ImagePageAfterImageLinks'][] = 'SEOTweaksHooksHelper::onImagePageAfterImageLinks';
$wgHooks['OpenGraphMetaHeaders'][] = 'SEOTweaksHooksHelper::onOpenGraphMetaHeaders';
$wgHooks['ArticleSaveComplete'][] = 'MyExtensionHooks::onArticleSaveComplete';
$wgHooks['ShowMissingArticle'][] = 'SEOTweaksHooksHelper::onShowMissingArticle';

// messages
$wgExtensionMessagesFiles['SEOTweaks'] = $dir . 'SEOTweaks.i18n.php';
