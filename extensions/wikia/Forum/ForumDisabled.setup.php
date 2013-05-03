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

$dir = dirname( __FILE__ ) . '/';
$app = F::app( );

include ($dir . '/Forum.namespace.setup.php');

$wgAutoloadClasses[ 'ForumNotificationPlugin'] =  $dir . 'ForumNotificationPlugin.class.php' ;

$wgHooks['NotificationGetNotificationMessage'][] = 'ForumNotificationPlugin::onGetNotificationMessage';
$wgHooks['NotificationGetMailNotificationMessage'][] = 'ForumNotificationPlugin::onGetMailNotificationMessage';

$app->registerExtensionMessageFile( 'Forum', $dir . 'Forum.i18n.php' );
