<?php
/**
 * SEOTweaks setup
 *
 * @author mech
 * @author ADi
 *
 */
$dir = dirname(__FILE__) . '/';
$app = F::app();

//classes
$app->registerClass('SEOTweaksHooksHelper', $dir . 'SEOTweaksHooksHelper.class.php');

// hooks
$app->registerHook('BeforePageDisplay', 'SEOTweaksHooksHelper', 'onBeforePageDisplay');
$app->registerHook('ArticleFromTitle', 'SEOTweaksHooksHelper', 'onArticleFromTitle');
