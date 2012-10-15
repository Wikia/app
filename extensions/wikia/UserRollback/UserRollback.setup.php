<?php

$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * controllers
 */
$app->registerClass('UserRollbackSpecialController', $dir . 'UserRollbackSpecialController.class.php');
$app->registerClass('UserRollbackRequest', $dir . 'UserRollbackRequest.class.php');

/**
 * special pages
 */
$app->registerSpecialPage('UserRollback', 'UserRollbackSpecialController');

/**
 * message files
 */
$app->registerExtensionMessageFile('UserRollback', $dir . 'UserRollback.i18n.php');

/**
 * setup rights
 */
$wgAvailableRights[] = 'userrollback';
$wgGroupPermissions['*']['userrollback'] = false;
$wgGroupPermissions['util']['userrollback'] = true;

/**
 * task manager
 */
extAddBatchTask( dirname(__FILE__)."/UserRollbackTask.class.php", "userrollback", "UserRollbackTask" );
