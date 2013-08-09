<?php

$dirExt = __DIR__;

$wgAutoloadClasses['WallNotifications'] = $dirExt . '/WallNotifications.class.php';

$wgAutoloadClasses['WallNotificationsAdmin'] = $dirExt . '/WallNotificationsAdmin.class.php';
$wgAutoloadClasses['WallNotificationAdminEntity'] = $dirExt . '/WallNotificationAdminEntity.class.php';

$wgAutoloadClasses['WallNotificationsOwner'] = $dirExt . '/WallNotificationsOwner.class.php';
$wgAutoloadClasses['WallNotificationOwnerEntity'] = $dirExt . '/WallNotificationOwnerEntity.class.php';

$wgAutoloadClasses['BaseNotificationEntity'] = $dirExt . '/BaseNotificationEntity.class.php';
$wgAutoloadClasses['WallNotificationEntity'] = $dirExt . '/WallNotificationEntity.class.php';
$wgAutoloadClasses['WallNotificationsController'] = $dirExt . '/WallNotificationsController.class.php';
$wgAutoloadClasses['WallNotificationsExternalController'] = $dirExt . '/WallNotificationsExternalController.class.php';

$wgAutoloadClasses['WallNotificationsEveryone'] = $dirExt . '/WallNotificationsEveryone.class.php';
$wgAutoloadClasses['WallNotificationsHooksHelper'] = $dirExt . '/WallNotificationsHooksHelper.class.php';

// Notifications are required on NonWall Wikis in order to show proper
// lower-left corner notification bubbles from Wall Wikis
$wgAutoloadClasses['WallHelper'] = $dirExt . '/../Wall/WallHelper.class.php';
$wgAutoloadClasses['WallMessage'] = $dirExt . '/../Wall/WallMessage.class.php';

//add script in monobook
$wgHooks['SkinAfterBottomScripts'][] = 'WallNotificationsHooksHelper::onSkinAfterBottomScripts';
$wgHooks['MakeGlobalVariablesScript'][] = 'WallNotificationsHooksHelper::onMakeGlobalVariablesScript';

$wgHooks['PersonalUrls'][] = 'WallNotificationsHooksHelper::onPersonalUrls';

$wgExtensionMessagesFiles['WallNotifications'] = $dirExt . '/WallNotifications.i18n.php';

F::build('JSMessages')->registerPackage('WallNotifications', array(
	'wall-notifications',
	'wall-notifications-reminder',
	'wall-notifications-wall-disabled',
));

// Notifications plugins
include( $dirExt . '/plugins/Forum/ForumNotificationsPlugin.setup.php' );
include( $dirExt . '/plugins/Wall/WallNotificationsPlugin.setup.php' );
