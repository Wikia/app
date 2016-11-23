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
$wgHooks['BeforePageDisplay'][] = 'SEOTweaksHooksHelper::onBeforePageDisplay';
$wgHooks['ImagePageAfterImageLinks'][] = 'SEOTweaksHooksHelper::onImagePageAfterImageLinks';
$wgHooks['BeforeParserMakeImageLinkObjOptions'][] = 'SEOTweaksHooksHelper::onBeforeParserMakeImageLinkObjOptions';
$wgHooks['ArticleViewHeader'][] = 'SEOTweaksHooksHelper::onArticleViewHeader';
$wgHooks['CategoryPageView'][] = 'SEOTweaksHooksHelper::onCategoryPageView';

// messages
$wgExtensionMessagesFiles['SEOTweaks'] = $dir . 'SEOTweaks.i18n.php';
