<?php 
/**
 * Forum
 *
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 *
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Forum',
	'author' => array( 'Kyle Florence', 'Saipetch Kongkatong', 'Tomasz Odrobny' )
);

$dir = dirname(__FILE__) . '/';
$app = F::app();


include($dir . '/Forum.namespace.setup.php');

$app->registerClass('ForumNotificationPlugin', $dir . 'ForumNotificationPlugin.class.php');

$app->registerHook( 'NotificationGetNotificationMessage', 'ForumNotificationPlugin', 'onGetNotificationMessage' );
$app->registerHook( 'NotificationGetMailNotificationMessage', 'ForumNotificationPlugin', 'onGetMailNotificationMessage' );

$app->registerExtensionMessageFile('Forum', $dir . 'Forum.i18n.php');