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