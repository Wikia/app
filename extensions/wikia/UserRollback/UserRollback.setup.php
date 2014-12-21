<?php

$dir = dirname(__FILE__) . '/';

/**
 * controllers
 */
$wgAutoloadClasses['UserRollbackSpecialController'] =  $dir . 'UserRollbackSpecialController.class.php';
$wgAutoloadClasses['UserRollbackRequest'] =  $dir . 'UserRollbackRequest.class.php';
$wgAutoloadClasses['UserRollbackTask'] = $dir . 'UserRollbackTask.class.php';

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
