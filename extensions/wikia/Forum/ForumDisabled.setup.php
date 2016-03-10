<?php
/**
 * Forum
 *
 * @author Kyle Florence, Saipetch Kongkatong, Tomasz Odrobny
 *
 */

$wgExtensionCredits['specialpage'][] = [
	'name' => 'Forum',
	'author' => [ 'Kyle Florence', 'Saipetch Kongkatong', 'Tomasz Odrobny' ],
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Forum',
	'descriptionmsg' => 'forum-disabled-desc'
];

$dir = dirname( __FILE__ ) . '/';

include ( $dir . '/Forum.namespace.setup.php' );

$wgAutoloadClasses[ 'ForumNotificationPlugin'] =  $dir . 'ForumNotificationPlugin.class.php' ;

$wgHooks['NotificationGetNotificationMessage'][] = 'ForumNotificationPlugin::onGetNotificationMessage';

$wgExtensionMessagesFiles['Forum'] = $dir . 'Forum.i18n.php' ;
