<?php

/**
 * Setup for WikiaBar - Meebo replacement
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */

$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$app->registerClass('WikiaBarController', $dir . 'WikiaBarController.class.php');
$app->registerClass('WikiaBarHooks', $dir . 'WikiaBarHooks.class.php');
$app->registerClass('WikiaBarModel', $dir . 'models/WikiaBarModel.class.php');
$app->registerClass('WikiaBarModelBase', $dir . 'models/WikiaBarModelBase.class.php');
$app->registerClass('WikiaBarDataModel', $dir . 'models/WikiaBarDataModel.class.php');
$app->registerClass('WikiaBarDataFailsafeModel', $dir . 'models/WikiaBarDataFailsafeModel.class.php');
$app->registerClass('WikiaBarDataValidator', $dir . 'models/WikiaBarDataValidator.class.php');
$app->registerClass('WikiaBarMessageDataValidator', $dir . 'models/WikiaBarMessageDataValidator.class.php');
$app->registerClass('WikiaBarFailsafeDataValidator', $dir . 'models/WikiaBarFailsafeDataValidator.class.php');

/**
 * hooks
 */
$app->registerHook('MakeGlobalVariablesScript', 'WikiaBarHooks', 'onMakeGlobalVariablesScript');
$app->registerHook('WikiFactoryChanged', 'WikiaBarHooks', 'onWikiFactoryVarChanged');
$app->registerHook('WikiFactoryVarSave::AfterErrorDetection', 'WikiaBarHooks', 'onWFAfterErrorDetection');

// i18n mapping
$wgExtensionMessagesFiles['WikiaBar'] = $dir . 'WikiaBar.i18n.php';
