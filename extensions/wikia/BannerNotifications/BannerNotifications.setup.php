<?php

/**
 * Docs are on internal in UI Style Guide
 */
$wgExtensionCredits['bannernotifications'][] = array(
	'name' => 'BannerNotifications',
	'descriptionmsg' => 'bannernotifications-desc',
	'author' => 'Hyun Lim',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/BannerNotifications'
);

$dir = dirname(__FILE__) . '/';

/**
 * Classes
 */
$wgAutoloadClasses[ 'NotificationsController' ] = $dir . 'NotificationsController.class.php';

/**
 * Hooks
 */
// confirmations
$wgHooks['ArticleDeleteComplete'][] = 'NotificationsController::addPageDeletedConfirmation';
$wgHooks['ArticleUndelete'][] = 'NotificationsController::addPageUndeletedConfirmation';
#$wgHooks['EditPageSuccessfulSave'][] = 'NotificationsController::addSaveConfirmation'; // BugId:10129
$wgHooks['SpecialMovepageAfterMove'][] = 'NotificationsController::addPageMovedConfirmation';
$wgHooks['SpecialPreferencesOnRender'][] = 'NotificationsController::addPreferencesConfirmation';
$wgHooks['UserLogoutComplete'][] = 'NotificationsController::addLogOutConfirmation';

// notifications
$wgHooks['AchievementsNotification'][] = 'NotificationsController::addBadgeNotification';
$wgHooks['CommunityMessages::showMessage'][] = 'NotificationsController::addCommunityMessagesNotification';
$wgHooks['EditSimilar::showMessage'][] = 'NotificationsController::addEditSimilarNotification';
$wgHooks['SiteWideMessagesNotification'][] = 'NotificationsController::addSiteWideMessageNotification';
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'NotificationsController::addMessageNotification';

/**
 * i18n
 */
$wgExtensionMessagesFiles['BannerNotification'] = $dir . 'BannerNotifications.i18n.php';
