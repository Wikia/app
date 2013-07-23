<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'Email Templates Extension',
	'descriptionmsg' => 'emailtemplates-extension-description',
	'author' => array(
		"[http://community.wikia.com/wiki/User:R-Frank Kamil 'R-Frank' Koterba]"
	),
);

$dir = __DIR__;

$wgExtensionMessagesFiles['EmailTemplates'] = $dir . '/EmailTemplates.i18n.php';

$wgAutoloadClasses['EmailTemplatesController'] = $dir . '/EmailTemplatesController.class.php';
$wgAutoloadClasses['EmailTemplatesHooksHelper'] = $dir . '/EmailTemplatesHooksHelper.class.php';

$wgHooks['ComposeCommonBodyMail'][] = 'EmailTemplatesHooksHelper::onComposeCommonBodyMail';
$wgHooks['ComposeCommonSubjectMail'][] = 'EmailTemplatesHooksHelper::onComposeCommonSubjectMail';
