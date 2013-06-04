<?php

$dirPlugin = __DIR__;

if ( !$wgEnableWallExt ) {
	include( $dirExt . '/../Wall/WallNamespaces.php' );
}

$app->registerClass( 'WallNotificationsPlugin', $dirPlugin . '/WallNotificationsPlugin.class.php' );

$app->registerHook( 'NotificationGetNotificationMessage', 'WallNotificationsPlugin', 'onGetNotificationMessage' );
$app->registerHook( 'NotificationGetMailNotificationMessage', 'WallNotificationsPlugin', 'onGetMailNotificationMessage' );

$app->registerExtensionMessageFile( 'WallNotificationsPlugin', $dirPlugin . '/WallNotificationsPlugin.i18n.php' );
