<?php

$app->registerClass('WallNotifications', $dir . '/WallNotifications.class.php');

$app->registerClass('WallNotificationsAdmin', $dir . '/WallNotificationsAdmin.class.php');
$app->registerClass('WallNotificationAdminEntity', $dir . '/WallNotificationAdminEntity.class.php');

$app->registerClass('WallNotificationsOwner', $dir . '/WallNotificationsOwner.class.php');
$app->registerClass('WallNotificationOwnerEntity', $dir . '/WallNotificationOwnerEntity.class.php');

$app->registerClass('WallNotificationEntity', $dir . '/WallNotificationEntity.class.php');
$app->registerClass('WallNotificationsController', $dir . '/WallNotificationsController.class.php');
$app->registerClass('WallNotificationsExternalController', $dir . '/WallNotificationsExternalController.class.php');
