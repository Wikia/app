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

// classes
$wgAutoloadClasses[ 'WikiaFilePage' ] = $dir . 'WikiaFilePage.php';
$wgAutoloadClasses[ 'WikiaMobileFilePage' ] = $dir . 'WikiaMobileFilePage.php';
$wgAutoloadClasses[ 'FilePageTabbed' ] = $dir . 'FilePageTabbed.php';
$wgAutoloadClasses[ 'WikiaWikiFilePage'] = $dir . 'WikiaWikiFilePage.php'; // Override for WikiFilePage

$wgAutoloadClasses[ 'FilePageHooks' ] = $dir . 'FilePageHooks.class.php';
$wgAutoloadClasses[ 'FilePageHelper' ] = $dir . 'FilePageHelper.class.php';

// file page controller
$wgAutoloadClasses[ 'FilePageController' ] = $dir . 'FilePageController.class.php';

// i18n mapping
$wgExtensionMessagesFiles['FilePage'] = $dir . 'FilePage.i18n.php' ;

// hooks
$wgHooks['ArticleFromTitle'][] = 'FilePageHooks::onArticleFromTitle';
$wgHooks['SkinTemplateNavigation'][] = 'FilePageHooks::onSkinTemplateNavigation';
$wgHooks['GlobalUsageFormatItemWikiLink'][] = 'FilePageHooks::onGlobalUsageFormatItemWikiLink';
$wgHooks['GlobalUsageImagePageWikiLink'][] = 'FilePageHooks::onGlobalUsageImagePageWikiLink';
$wgHooks['GlobalUsageLinksUpdateComplete'][] = 'FilePageHooks::onGlobalUsageLinksUpdateComplete';
$wgHooks['BeforePageDisplay'][] = 'FilePageHooks::onBeforePageDisplay';
$wgHooks['WikiaMobileAssetsPackages'][] = 'FilePageHooks::onWikiaMobileAssetsPackages';