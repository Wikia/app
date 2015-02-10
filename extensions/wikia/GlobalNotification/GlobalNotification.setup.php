<?php

/**
 * Css lives here: /skins/oasis/css/core/GlobalNotification.scss
 * Docs are on internal in UI Style Guide
 */
$wgExtensionCredits['globalnotification'][] = array(
	'name' => 'GlobalNotification',
	'descriptionmsg' => 'globalnotification-desc',
	'author' => 'Hyun Lim',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/GlobalNotification'
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
$wgExtensionMessagesFiles['GlobalNotification'] = $dir . 'GlobalNotification.i18n.php';
