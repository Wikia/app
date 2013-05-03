<?php

$dirnotification = dirname(__FILE__);

$wgAutoloadClasses['WallNotifications'] =  $dirnotification . '/WallNotifications.class.php';

$wgAutoloadClasses['WallNotificationsAdmin'] =  $dirnotification . '/WallNotificationsAdmin.class.php';
$wgAutoloadClasses['WallNotificationAdminEntity'] =  $dirnotification . '/WallNotificationAdminEntity.class.php';

$wgAutoloadClasses['WallNotificationsOwner'] =  $dirnotification . '/WallNotificationsOwner.class.php';
$wgAutoloadClasses['WallNotificationOwnerEntity'] =  $dirnotification . '/WallNotificationOwnerEntity.class.php';

$wgAutoloadClasses['WallNotificationEntity'] =  $dirnotification . '/WallNotificationEntity.class.php';
$wgAutoloadClasses['WallNotificationsController'] =  $dirnotification . '/WallNotificationsController.class.php';
$wgAutoloadClasses['WallNotificationsExternalController'] =  $dirnotification . '/WallNotificationsExternalController.class.php';

$wgAutoloadClasses['WallNotificationsEveryone'] =  $dirnotification . '/WallNotificationsEveryone.class.php';
$wgAutoloadClasses['WallNotificationsHooksHelper'] =  $dirnotification . '/WallNotificationsHooksHelper.class.php';

// Notifications are required on NonWall Wikis in order to show proper
// lower-left corner notification bubbles from Wall Wikis
$wgAutoloadClasses['WallHelper'] =  $dir . '/WallHelper.class.php';
$wgAutoloadClasses['WallMessage'] =  $dir . '/WallMessage.class.php';

//add script in monobook
$app->registerHook('SkinAfterBottomScripts', 'WallNotificationsHooksHelper', 'onSkinAfterBottomScripts');
$app->registerHook('MakeGlobalVariablesScript', 'WallNotificationsHooksHelper', 'onMakeGlobalVariablesScript');

$app->registerHook('PersonalUrls', 'WallNotificationsHooksHelper', 'onPersonalUrls');