<?php

$dirPlugin = __DIR__;

if ( !$wgEnableForumExt ) {
	include( $dirExt . '/../Forum/Forum.namespace.setup.php' );
}

$app->registerClass( 'ForumNotificationsPlugin', $dirPlugin . '/ForumNotificationsPlugin.class.php' );

$app->registerHook( 'NotificationGetNotificationMessage', 'ForumNotificationsPlugin', 'onGetNotificationMessage' );
$app->registerHook( 'NotificationGetMailNotificationMessage', 'ForumNotificationsPlugin', 'onGetMailNotificationMessage' );

$app->registerExtensionMessageFile( 'Forum', $dirPlugin . '/ForumNotificationsPlugin.i18n.php' );
