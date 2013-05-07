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
$app = F::app();

//classes
$wgAutoloadClasses['SEOTweaksHooksHelper'] =  $dir . 'SEOTweaksHooksHelper.class.php';

// hooks
$wgHooks['BeforePageDisplay'][] = 'SEOTweaksHooksHelper::onBeforePageDisplay';
$wgHooks['ArticleFromTitle'][] = 'SEOTweaksHooksHelper::onArticleFromTitle';
$wgHooks['ImagePageAfterImageLinks'][] = 'SEOTweaksHooksHelper::onImagePageAfterImageLinks';
$wgHooks['BeforeParserMakeImageLinkObjOptions'][] = 'SEOTweaksHooksHelper::onBeforeParserMakeImageLinkObjOptions';
$wgHooks['ArticleViewHeader'][] = 'SEOTweaksHooksHelper::onArticleViewHeader';

// messages
$app->registerExtensionMessageFile('SEOTweaks', $dir . 'SEOTweaks.i18n.php');