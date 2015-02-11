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
$wgAutoloadClasses[ 'BannerNotificationsController' ] = $dir . 'BannerNotificationsController.class.php';

/**
 * Hooks
 */
// confirmations
$wgHooks['ArticleDeleteComplete'][] = 'BannerNotificationsController::addPageDeletedConfirmation';
$wgHooks['ArticleUndelete'][] = 'BannerNotificationsController::addPageUndeletedConfirmation';
#$wgHooks['EditPageSuccessfulSave'][] = 'BannerNotificationsController::addSaveConfirmation'; // BugId:10129
$wgHooks['SpecialMovepageAfterMove'][] = 'BannerNotificationsController::addPageMovedConfirmation';
$wgHooks['SpecialPreferencesOnRender'][] = 'BannerNotificationsController::addPreferencesConfirmation';
$wgHooks['UserLogoutComplete'][] = 'BannerNotificationsController::addLogOutConfirmation';

// notifications
$wgHooks['AchievementsNotification'][] = 'BannerNotificationsController::addBadgeNotification';
$wgHooks['CommunityMessages::showMessage'][] = 'BannerNotificationsController::addCommunityMessagesNotification';
$wgHooks['EditSimilar::showMessage'][] = 'BannerNotificationsController::addEditSimilarNotification';
$wgHooks['SiteWideMessagesNotification'][] = 'BannerNotificationsController::addSiteWideMessageNotification';
$wgHooks['SkinTemplateOutputPageBeforeExec'][] = 'BannerNotificationsController::addMessageNotification';

/**
 * i18n
 */
$wgExtensionMessagesFiles['BannerNotification'] = $dir . 'BannerNotifications.i18n.php';
