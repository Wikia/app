<?php
/**
 * This extension is for the Special:Tasks page, and for the proxy executor.
 */
if (!defined('MEDIAWIKI')) {
	exit(1);
}

$dir = __DIR__;

$wgAutoloadClasses['TasksModel'] = "$dir/TasksModel.class.php";
$wgAutoloadClasses['TasksSpecialController'] = "$dir/TasksSpecialController.class.php";

$wgSpecialPages['Tasks'] = 'TasksSpecialController';

$wgExtensionMessagesFiles['Tasks'] = "$dir/Tasks.i18n.php";

$wgAvailableRights []= 'tasks-user';
$wgGroupPermissions['vstf']['tasks-user'] = true;
$wgGroupPermissions['helper']['tasks-user'] = true;
$wgGroupPermissions['staff']['tasks-user'] = true;
$wgGroupPermissions['util']['tasks-user'] = true;