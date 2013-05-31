<?php

$app = F::app();

$dirExt = __DIR__;

$app->registerClass('WallNotifications', $dirExt . '/WallNotifications.class.php');

$app->registerClass('WallNotificationsAdmin', $dirExt . '/WallNotificationsAdmin.class.php');
$app->registerClass('WallNotificationAdminEntity', $dirExt . '/WallNotificationAdminEntity.class.php');

$app->registerClass('WallNotificationsOwner', $dirExt . '/WallNotificationsOwner.class.php');
$app->registerClass('WallNotificationOwnerEntity', $dirExt . '/WallNotificationOwnerEntity.class.php');

$app->registerClass('WallNotificationEntity', $dirExt . '/WallNotificationEntity.class.php');
$app->registerClass('WallNotificationsController', $dirExt . '/WallNotificationsController.class.php');
$app->registerClass('WallNotificationsExternalController', $dirExt . '/WallNotificationsExternalController.class.php');

$app->registerClass('WallNotificationsEveryone', $dirExt . '/WallNotificationsEveryone.class.php');
$app->registerClass('WallNotificationsHooksHelper', $dirExt . '/WallNotificationsHooksHelper.class.php');

// Notifications are required on NonWall Wikis in order to show proper
// lower-left corner notification bubbles from Wall Wikis
$app->registerClass('WallHelper', $dirExt . '/../Wall/WallHelper.class.php');
$app->registerClass('WallMessage', $dirExt . '/../Wall/WallMessage.class.php');

//add script in monobook
$app->registerHook('SkinAfterBottomScripts', 'WallNotificationsHooksHelper', 'onSkinAfterBottomScripts');
$app->registerHook('MakeGlobalVariablesScript', 'WallNotificationsHooksHelper', 'onMakeGlobalVariablesScript');

$app->registerHook('PersonalUrls', 'WallNotificationsHooksHelper', 'onPersonalUrls');

// Notifications plugins
include( $dirExt . '/plugins/Forum/ForumNotificationsPlugin.setup.php' );
