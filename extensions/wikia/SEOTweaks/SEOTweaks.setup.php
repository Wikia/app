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
$wgHooks['OpenGraphMetaHeaders'][] = 'SEOTweaksHooksHelper::onOpenGraphMetaHeaders';
$wgHooks['ShowMissingArticle'][] = 'SEOTweaksHooksHelper::onShowMissingArticle';

if ( $wgLanguageCode == 'en' ) {
    $wgHooks['ArticleViewHeader'][] = 'SEOTweaksHooksHelper::onArticleViewHeader';
    $wgHooks['BeforeParserMakeImageLinkObjOptions'][] = 'SEOTweaksHooksHelper::onBeforeParserMakeImageLinkObjOptions';
    $wgHooks['CategoryPageView'][] = 'SEOTweaksHooksHelper::onCategoryPageView';
    $wgHooks['ImagePageAfterImageLinks'][] = 'SEOTweaksHooksHelper::onImagePageAfterImageLinks';
}

// messages
$wgExtensionMessagesFiles['SEOTweaks'] = $dir . 'SEOTweaks.i18n.php';
