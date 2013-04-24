<?php

/**
 * File Page
 *
 * @author Garth Webb, Hyun Lim, Liz Lee, Saipetch Kongkatong
 *
 */

$wgExtensionCredits['filepage'][] = array(
	'name' => 'FilePage',
	'author' => array(
		"Garth Webb",
		"Hyun Lim",
		"Liz Lee",
		"Saipetch Kongkatong",
	),
	'descriptionmsg' => 'filepage-desc',
);

$dir = dirname( __FILE__ ) . '/';
$app = F::app( );

// classes
$app->registerClass( 'WikiaImagePage', $dir . 'ImagePage.php' );
$app->registerClass( 'WikiaVideoPage', $dir . 'VideoPage.php' );
$app->registerClass( 'FilePageHooks', $dir . 'FilePageHooks.class.php' );
$app->registerClass( 'FilePageHelper', $dir . 'FilePageHelper.class.php' );

// file page controller
$app->registerClass( 'FilePageController', $dir . 'FilePageController.class.php' );

// i18n mapping
$app->registerExtensionMessageFile( 'FilePage', $dir . 'FilePage.i18n.php' );

// hooks
$app->registerHook( 'ArticleFromTitle', 'FilePageHooks', 'onArticleFromTitle' );
$app->registerHook( 'SkinTemplateNavigation', 'FilePageHooks', 'onSkinTemplateNavigation' );
$app->registerHook( 'GlobalUsageFormatItemWikiLink', 'FilePageHooks', 'onGlobalUsageFormatItemWikiLink' );
$app->registerHook( 'GlobalUsageImagePageWikiLink', 'FilePageHooks', 'onGlobalUsageImagePageWikiLink' );
$app->registerHook( 'GlobalUsageLinksUpdateComplete', 'FilePageHooks', 'onGlobalUsageLinksUpdateComplete' );
$app->registerHook( 'BeforePageDisplay', 'FilePageHooks', 'onBeforePageDisplay' );
