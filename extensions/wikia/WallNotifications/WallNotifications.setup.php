<?php

$app = F::app();

$dir = dirname(__FILE__);

$app->registerClass('WallNotifications', $dir . '/WallNotifications.class.php');

$app->registerClass('WallNotificationsAdmin', $dir . '/WallNotificationsAdmin.class.php');
$app->registerClass('WallNotificationAdminEntity', $dir . '/WallNotificationAdminEntity.class.php');

$app->registerClass('WallNotificationsOwner', $dir . '/WallNotificationsOwner.class.php');
$app->registerClass('WallNotificationOwnerEntity', $dir . '/WallNotificationOwnerEntity.class.php');

$app->registerClass('WallNotificationEntity', $dir . '/WallNotificationEntity.class.php');
$app->registerClass('WallNotificationsController', $dir . '/WallNotificationsController.class.php');
$app->registerClass('WallNotificationsExternalController', $dir . '/WallNotificationsExternalController.class.php');

$app->registerClass('WallNotificationsEveryone', $dir . '/WallNotificationsEveryone.class.php');
$app->registerClass('WallNotificationsHooksHelper', $dir . '/WallNotificationsHooksHelper.class.php');

// Notifications are required on NonWall Wikis in order to show proper
// lower-left corner notification bubbles from Wall Wikis
$app->registerClass('WallHelper', $dir . '/../Wall/WallHelper.class.php');
$app->registerClass('WallMessage', $dir . '/../Wall/WallMessage.class.php');

//add script in monobook
$app->registerHook('SkinAfterBottomScripts', 'WallNotificationsHooksHelper', 'onSkinAfterBottomScripts');
$app->registerHook('MakeGlobalVariablesScript', 'WallNotificationsHooksHelper', 'onMakeGlobalVariablesScript');

$app->registerHook('PersonalUrls', 'WallNotificationsHooksHelper', 'onPersonalUrls');
