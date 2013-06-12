<?php

$dir = dirname(__FILE__);

$app = F::app();

$wgExtensionMessagesFiles['EmailTemplates'] = $dir . '/EmailTemplates.i18n.php';

$app->registerClass('EmailTemplatesController', $dir.'/EmailTemplatesController.class.php');
$app->registerClass('EmailTemplatesHooksHelper', $dir . '/EmailTemplatesHooksHelper.class.php');

$app->registerHook('ComposeCommonBodyMail', 'EmailTemplatesHooksHelper', 'onComposeCommonBodyMail' );
$app->registerHook('ComposeCommonSubjectMail', 'EmailTemplatesHooksHelper', 'onComposeCommonSubjectMail' );
