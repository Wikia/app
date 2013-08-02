<?php

$dirPlugin = __DIR__;

if ( !defined( 'NS_USER_WALL' ) ) {
	include( $dirExt . '/../Wall/WallNamespaces.php' );
}

$wgAutoloadClasses['WallNotificationsPlugin'] = $dirPlugin . '/WallNotificationsPlugin.class.php';

$wgHooks['NotificationGetNotificationMessage'][] = 'WallNotificationsPlugin::onGetNotificationMessage';
$wgHooks['NotificationGetMailNotificationMessage'][] = 'WallNotificationsPlugin::onGetMailNotificationMessage';

$wgExtensionMessagesFiles['WallNotificationsPlugin'] = $dirPlugin . '/WallNotificationsPlugin.i18n.php';
