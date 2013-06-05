<?php

$dir = dirname(__FILE__);

$app = F::app();

$app->registerClass('EmailTemplatesController', $dir.'/EmailTemplatesController.class.php');
$app->registerClass('EmailTemplatesHooksHelper', $dir . '/EmailTemplatesHooksHelper.class.php');

$app->registerHook('ComposeCommonBodyMail', 'EmailTemplatesHooksHelper', 'onComposeCommonBodyMail' );
