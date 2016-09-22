<?php

/**
 * Docs are on internal in UI Style Guide
 */
$wgExtensionCredits['bannernotifications'][] = array(
	'name' => 'BannerNotifications',
	'descriptionmsg' => 'bannernotifications-desc',
	'author' => [
		'Hyun Lim',
		'Maciej Brencz',
		'Bartłomiej (Bart) Kowalczyk'
	],
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/BannerNotifications'
);

$dir = dirname(__FILE__) . '/';

/**
 * Classes
 */
$wgAutoloadClasses[ 'BannerNotificationsController' ] = $dir . 'BannerNotificationsController.class.php';

/**
 * Hooks
 */
$wgHooks['ArticleDeleteComplete'][] = 'BannerNotificationsController::addPageDeletedConfirmation';
$wgHooks['ArticleUndelete'][] = 'BannerNotificationsController::addPageUndeletedConfirmation';
$wgHooks['SpecialMovepageAfterMove'][] = 'BannerNotificationsController::addPageMovedConfirmation';
$wgHooks['SpecialPreferencesOnRender'][] = 'BannerNotificationsController::addPreferencesConfirmation';
$wgHooks['UserLogoutComplete'][] = 'BannerNotificationsController::addLogOutConfirmation';
$wgHooks['SkinAfterBottomScripts'][] = 'BannerNotificationsController::onSkinAfterBottomScripts';
$wgHooks['BeforePageDisplay'][] = 'BannerNotificationsController::onBeforePageDisplay';

/**
 * i18n
 */
$wgExtensionMessagesFiles['BannerNotification'] = $dir . 'BannerNotifications.i18n.php';

/**
 * ResourceLoader module
 */
$wgResourceModules['ext.bannerNotifications'] = [
	'scripts' => [
		'BannerNotifications.js',
		'templates.mustache.js',
	],
	'messages' => [
		'bannernotifications-general-ajax-failure',
	],
	'localBasePath' => __DIR__ . '/js',
	'remoteExtPath' => 'wikia/BannerNotifications',
];
