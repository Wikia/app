<?php

$dir = dirname(__FILE__) . '/';

/**
 * controllers
 */
$wgAutoloadClasses['UserRollbackSpecialController'] =  $dir . 'UserRollbackSpecialController.class.php';
$wgAutoloadClasses['UserRollbackRequest'] =  $dir . 'UserRollbackRequest.class.php';
$wgAutoloadClasses['UserRollbackTask'] = $dir . 'UserRollbackTask.class.php';
$wgAutoloadClasses['OldUserRollbackTask'] = $dir . 'UserRollbackTask.old.php';

/**
 * special pages
 */
$wgSpecialPages['UserRollback'] = 'UserRollbackSpecialController';

/**
 * message files
 */
$wgExtensionMessagesFiles['UserRollback'] = $dir . 'UserRollback.i18n.php';

/**
 * setup rights
 */
$wgAvailableRights[] = 'userrollback';
$wgGroupPermissions['*']['userrollback'] = false;
$wgGroupPermissions['util']['userrollback'] = true;

/**
 * task manager
 */
extAddBatchTask( dirname(__FILE__)."/UserRollbackTask.old.php", "userrollback", "OldUserRollbackTask" );
