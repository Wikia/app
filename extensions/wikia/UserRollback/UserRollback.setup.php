<?php


$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
//$app->registerClass('HelloWorld', $dir . 'HelloWorld.class.php');

/**
 * hooks
 */
//$app->registerHook('OutputPageBeforeHTML', 'HelloWorld', 'onOutputPageBeforeHTML');

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

/**
 * setup functions
 */
/*
$app->registerExtensionFunction('wfExtensionInit');

function wfExtensionInit() {
	// place extension init stuff here
	
	return true; // needed so that other extension initializations continue
}
*/
