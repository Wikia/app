<?php

$dirnotification = dirname(__FILE__);

$app->registerClass('WallNotifications', $dirnotification . '/WallNotifications.class.php');

$app->registerClass('WallNotificationsAdmin', $dirnotification . '/WallNotificationsAdmin.class.php');
$app->registerClass('WallNotificationAdminEntity', $dirnotification . '/WallNotificationAdminEntity.class.php');

$app->registerClass('WallNotificationsOwner', $dirnotification . '/WallNotificationsOwner.class.php');
$app->registerClass('WallNotificationOwnerEntity', $dirnotification . '/WallNotificationOwnerEntity.class.php');

$app->registerClass('WallNotificationEntity', $dirnotification . '/WallNotificationEntity.class.php');
$app->registerClass('WallNotificationsController', $dirnotification . '/WallNotificationsController.class.php');
$app->registerClass('WallNotificationsExternalController', $dirnotification . '/WallNotificationsExternalController.class.php');

$app->registerClass('WallNotificationsEveryone', $dirnotification . '/WallNotificationsEveryone.class.php');
$app->registerClass('WallNotificationsHooksHelper', $dirnotification . '/WallNotificationsHooksHelper.class.php');

// Notifications are required on NonWall Wikis in order to show proper
// lower-left corner notification bubbles from Wall Wikis
$app->registerClass('WallHelper', $dir . '/WallHelper.class.php');
$app->registerClass('WallMessage', $dir . '/WallMessage.class.php');

//add script in monobook
$app->registerHook('SkinAfterBottomScripts', 'WallNotificationsHooksHelper', 'onSkinAfterBottomScripts');
$app->registerHook('MakeGlobalVariablesScript', 'WallNotificationsHooksHelper', 'onMakeGlobalVariablesScript');

$app->registerHook('PersonalUrls', 'WallNotificationsHooksHelper', 'onPersonalUrls');