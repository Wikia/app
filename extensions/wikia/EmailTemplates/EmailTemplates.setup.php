<?php

$wgExtensionMessagesFiles['EmailTemplates'] = $dir . '/EmailTemplates.i18n.php';

$wgAutoloadClasses['EmailTemplatesController'] = $dir . '/EmailTemplatesController.class.php';
$wgAutoloadClasses['EmailTemplatesHooksHelper'] = $dir . '/EmailTemplatesHooksHelper.class.php';

$wgHooks['ComposeCommonBodyMail'][] = 'EmailTemplatesHooksHelper::onComposeCommonBodyMail';
$wgHooks['ComposeCommonSubjectMail'][] = 'EmailTemplatesHooksHelper::onComposeCommonSubjectMail';
