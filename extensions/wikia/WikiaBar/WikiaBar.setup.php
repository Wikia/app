<?php

/**
 * Setup for WikiaBar - Meebo replacement
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 */

$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$wgAutoloadClasses['WikiaBarController'] =  $dir . 'WikiaBarController.class.php';
$wgAutoloadClasses['WikiaBarHooks'] =  $dir . 'WikiaBarHooks.class.php';
$wgAutoloadClasses['WikiaBarModel'] =  $dir . 'models/WikiaBarModel.class.php';
$wgAutoloadClasses['WikiaBarModelBase'] =  $dir . 'models/WikiaBarModelBase.class.php';
$wgAutoloadClasses['WikiaBarDataModel'] =  $dir . 'models/WikiaBarDataModel.class.php';
$wgAutoloadClasses['WikiaBarDataFailsafeModel'] =  $dir . 'models/WikiaBarDataFailsafeModel.class.php';
$wgAutoloadClasses['WikiaBarDataValidator'] =  $dir . 'models/WikiaBarDataValidator.class.php';
$wgAutoloadClasses['WikiaBarMessageDataValidator'] =  $dir . 'models/WikiaBarMessageDataValidator.class.php';
$wgAutoloadClasses['WikiaBarFailsafeDataValidator'] =  $dir . 'models/WikiaBarFailsafeDataValidator.class.php';

$wgAutoloadClasses['WikiaBarUserPropertiesHandler'] =  $dir . 'models/WikiaBarUserPropertiesHandler.class.php';
WikiaUserPropertiesController::registerHandler('WikiaBarUserPropertiesHandler');

/**
 * hooks
 */
$wgHooks['MakeGlobalVariablesScript'][] = 'WikiaBarHooks::onMakeGlobalVariablesScript';
$wgHooks['WikiFactoryChanged'][] = 'WikiaBarHooks::onWikiFactoryVarChanged';
$wgHooks['WikiFactoryVarSave::AfterErrorDetection'][] = 'WikiaBarHooks::onWFAfterErrorDetection';

// i18n mapping
$wgExtensionMessagesFiles['WikiaBar'] = $dir . 'WikiaBar.i18n.php';
