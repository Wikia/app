<?php

/**
 * Note: This file isn't actually included anywhere
 * GlobalNotifications controller lives here: /skins/oasis/modules/NotificationsController.class.php
 * Css lives here: /skins/oasis/css/core/GlobalNotification.scss
 * Docs are on internal in UI Style Guide
 */

$wgExtensionCredits['globalnotification'][] = array(
	'name' => 'GlobalNotification',
	'descriptionmsg' => 'globalnotification-desc',
	'author' => array('Hyun Lim')
);

$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['GlobalNotification'] = $dir . 'GlobalNotification.i18n.php';
