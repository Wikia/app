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
$app->registerClass('SEOTweaksHooksHelper', $dir . 'SEOTweaksHooksHelper.class.php');

// hooks
$app->registerHook('BeforePageDisplay', 'SEOTweaksHooksHelper', 'onBeforePageDisplay');
$app->registerHook('AfterInitialize', 'SEOTweaksHooksHelper', 'onAfterInitialize');
$app->registerHook('ImagePageAfterImageLinks', 'SEOTweaksHooksHelper', 'onImagePageAfterImageLinks');
$app->registerHook('BeforeParserMakeImageLinkObjOptions', 'SEOTweaksHooksHelper', 'onBeforeParserMakeImageLinkObjOptions');
$app->registerHook('ArticleViewHeader', 'SEOTweaksHooksHelper', 'onArticleViewHeader');

// messages
$app->registerExtensionMessageFile('SEOTweaks', $dir . 'SEOTweaks.i18n.php');