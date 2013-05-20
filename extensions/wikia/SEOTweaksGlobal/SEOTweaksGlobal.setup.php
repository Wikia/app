<?php
/**
 * SEOTweaks setup
 *
 * @author Jacek Jursza <jacek at wikia-inc.com>
 *
 */
$dir = dirname(__FILE__) . '/';
$app = F::app();

//classes
$app->registerClass('SEOTweaksGlobalHooksHelper', $dir . 'SEOTweaksGlobalHooksHelper.class.php');

//hooks
$app->registerHook( 'OpenGraphMetaHeaders', 'SEOTweaksGlobalHooksHelper', 'onOpenGraphMetaHeaders' );
$app->registerHook( 'ArticleRobotPolicy', 'SEOTweaksGlobalHooksHelper', 'onArticleRobotPolicy' );