<?php

/*
 *  GlobalNotifications controller lives here: /skins/oasis/modules/NotificationsController.class.php
 *  Css lives here: /skins/oasis/css/core/GlobalNotification.scss
 *  Docs are on internal in UI Style Guide
 */

$wgExtensionCredits['globalnotification'][] = array(
	'name' => 'GlobalNotification',
	'descriptionmsg' => 'globalnotification-desc',
	'author' => 'Hyun Lim',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/GlobalNotification'
);

$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['GlobalNotification'] = $dir . 'GlobalNotification.i18n.php';

// TODO: make this use JSMessages later instead of JSVar hook
//JSMessages::registerPackage('GlobalNotification', array('globalnotification-*'));

$wgHooks["MakeGlobalVariablesScript"][] = "wfGlobalNotificationJSVars";

function wfGlobalNotificationJSVars(Array &$vars) {
	$vars['wgAjaxFailureMsg'] = wfMsg('globalnotification-general-ajax-failure');
	return true;
}
