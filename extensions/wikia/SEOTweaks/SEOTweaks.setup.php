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
$app->registerHook('ArticleFromTitle', 'SEOTweaksHooksHelper', 'onArticleFromTitle');
$app->registerHook('ImagePageAfterImageLinks', 'SEOTweaksHooksHelper', 'onImagePageAfterImageLinks');


// messages
$app->registerExtensionMessageFile('SEOTweaks', $dir . 'SEOTweaks.i18n.php');