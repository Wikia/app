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
$wgHooks['AfterInitialize'][] = 'SEOTweaksHooksHelper::onAfterInitialize';
$wgHooks['ImagePageAfterImageLinks'][] = 'SEOTweaksHooksHelper::onImagePageAfterImageLinks';
$wgHooks['BeforeParserMakeImageLinkObjOptions'][] = 'SEOTweaksHooksHelper::onBeforeParserMakeImageLinkObjOptions';
$wgHooks['ArticleViewHeader'][] = 'SEOTweaksHooksHelper::onArticleViewHeader';

// messages
$wgExtensionMessagesFiles['SEOTweaks'] = $dir . 'SEOTweaks.i18n.php';