<?php

$dirPlugin = __DIR__;

if ( !defined( 'NS_WIKIA_FORUM_BOARD' ) ) {
	include( $dirExt . '/../Forum/Forum.namespace.setup.php' );
}

$wgAutoloadClasses['ForumNotificationsPlugin'] = $dirPlugin . '/ForumNotificationsPlugin.class.php';

$wgHooks['NotificationGetNotificationMessage'][] = 'ForumNotificationsPlugin::onGetNotificationMessage';
$wgHooks['NotificationGetMailNotificationMessage'][] = 'ForumNotificationsPlugin::onGetMailNotificationMessage';

$wgExtensionMessagesFiles['ForumNotificationsPlugin'] = $dirPlugin . '/ForumNotificationsPlugin.i18n.php';
