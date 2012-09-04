<?php

$wgExtensionCredits['globalnotification'][] = array(
	'name' => 'GlobalNotification',
	'descriptionmsg' => 'globalnotification-desc',
	'author' => array('Hyun Lim')
);

$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['GlobalNotification'] = $dir . 'GlobalNotification.i18n.php';

// TODO: make this use JSMessages later instead of JSVar hook
//F::build('JSMessages')->registerPackage('GlobalNotification', array('globalnotification-*'));

$wgHooks["MakeGlobalVariablesScript"][] = "wfGlobalNotificationJSVars";

function wfGlobalNotificationJSVars(Array &$vars) {
	$vars['wgAjaxFailureMsg'] = wfMsg('globalnotification-general-ajax-failure');
	return true;
}
